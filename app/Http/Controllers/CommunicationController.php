<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    // List communications
    public function index()
    {
        $user = auth()->user();

        // Mark all unread communication notifications as read
        $user->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $communications = Communication::latest()->paginate(10);

        return view('communications.index', compact('communications'));
    }

    // Create form (Chairman, Secretary, Treasurer)
    public function create()
    {
        return view('communications.create');
    }

    // Store communication
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:announcement,notice,memo',
            'audience_type' => 'required|in:all,committee,role,specific',
            'allowed_roles' => 'nullable|array',
            'specific_users' => 'nullable|array',
        ]);

        $validated['created_by'] = auth()->id();

        $communication = Communication::create($validated);

        // Notify users
        $users = $this->getTargetUsers($communication);
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "New {$communication->type}: {$communication->title}",
                'link' => route('communications.index'),
            ]);
        }

        return redirect()->route('communications.index')->with('success', 'Communication sent.');
    }

    // Helper to get target users
    private function getTargetUsers($communication)
    {
        $query = User::query();

        switch ($communication->audience_type) {
            case 'all':
                return $query->get();
            case 'committee':
                return $query->whereIn('role', ['chairman', 'secretary', 'treasurer'])->get();
            case 'role':
                return $query->whereIn('role', $communication->allowed_roles)->get();
            case 'specific':
                return $query->whereIn('id', $communication->specific_users)->get();
        }
    }

    // Show single communication
    public function show(Communication $communication)
    {
        

       

        return view('communications.show', compact('communication'));
    }

    public function edit(Communication $communication)
    {
        // Check authorization
        if (auth()->user()->role === 'member' && $communication->creator_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('communications.edit', compact('communication'));
    }

    public function update(Request $request, Communication $communication)
    {
        // Check authorization
        if (auth()->user()->role === 'member' && $communication->creator_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:announcement,notice,memo,reminder,update',
            'audience_type' => 'required|in:all,committee,role,specific',
            'allowed_roles' => 'nullable|array',
            'allowed_roles.*' => 'in:member,secretary,treasurer,chairman',
            'specific_users' => 'nullable|array',
            'specific_users.*' => 'exists:users,id',
        ]);

        // Convert arrays to JSON for database storage
        if (isset($validated['allowed_roles'])) {
            $validated['allowed_roles'] = json_encode($validated['allowed_roles']);
        }

        if (isset($validated['specific_users'])) {
            $validated['specific_users'] = json_encode($validated['specific_users']);
        }

        $communication->update($validated);

        return redirect()->route('communications.show', $communication)
            ->with('success', 'Notification updated successfully.');
    }

    public function destroy(Communication $communication)
    {
        // Check authorization (only admins/creators can delete)
        if (auth()->user()->role === 'member' && $communication->creator_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $communication->delete();

        return redirect()->route('communications.index')
            ->with('success', 'Notification deleted successfully.');
    }
}
