<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    /**
     * Secretary documents page (upload + list)
     */
    public function secretaryIndex()
    {
        $documents = Document::with('uploader')
            ->where('uploaded_by', auth()->id())
            ->latest()
            ->paginate(10);

        $users = User::where('id', '!=', auth()->id())
            ->select('id', 'name', 'role')
            ->orderBy('name')
            ->get();

        return view('secretary.documents', compact('documents', 'users'));
    }

    /**
     * Documents list for all users
     */
    public function index()
    {
        $user = auth()->user();

        $documents = Document::with('uploader')
            ->where(function ($q) use ($user) {

                // Public
                $q->where('is_public', true)

                // Own uploads
                ->orWhere('uploaded_by', $user->id)

                // Chairman sees all
                ->orWhere(fn ($x) =>
                    $user->role === 'chairman' ? $x->whereRaw('1=1') : null
                )

                // Committee
                ->orWhere(function ($x) use ($user) {
                    $x->where('access_type', 'committee')
                      ->whereJsonContains('allowed_roles', $user->role);
                })

                // Members
                ->orWhere(function ($x) {
                    $x->where('access_type', 'members');
                })

                // Specific users
                ->orWhere(function ($x) use ($user) {
                    $x->where('access_type', 'specific_users')
                      ->whereJsonContains('specific_users', $user->id);
                });
            })
            ->latest()
            ->paginate(10);

        return view('documents.index', compact('documents'));
    }

    /**
     * Store uploaded document
     */
    public function store(Request $request)
    {
        // Security
        abort_unless(auth()->user()->role === 'secretary', 403);

        // Validation (NO fragile rules)
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'category'        => 'required|string|in:minutes,loans,members,financial,policy,other',
            'access_type'     => 'required|string|in:public,committee,members,specific_users',
            'allowed_roles'   => 'nullable|array',
            'allowed_roles.*' => 'in:chairman,secretary,treasurer,member',
            'specific_users'  => 'nullable|array',
            'specific_users.*'=> 'exists:users,id',
            'file'            => 'required|file|max:10240',
        ]);

        // File MUST exist here or we hard stop
        if (!$request->hasFile('file')) {
            abort(422, 'File not received by server.');
        }

        $file = $request->file('file');

        // Folder
        $folder = $this->folderFor($data['category']);

        // Store
        $path = $file->store($folder, 'public');

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(500, 'File storage failed.');
        }

        // Create record
        Document::create([
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'category'      => $data['category'],
            'file_path'     => $path,
            'file_name'     => $file->getClientOriginalName(),
            'file_size'     => $file->getSize(),
            'file_type'     => $file->getMimeType(),
            'access_type'   => $data['access_type'],
            'allowed_roles' => $data['allowed_roles'] ?? null,
            'specific_users'=> $data['specific_users'] ?? null,
            'uploaded_by'   => auth()->id(),
            'is_public'     => $data['access_type'] === 'public',
        ]);

        return redirect()
            ->route('secretary.documents')
            ->with('success', 'Document uploaded successfully.');
    }

    /**
     * Download document
     */
    public function download($id)
    {
        $document = Document::findOrFail($id);
        $user = auth()->user();

        abort_unless($document->canBeAccessedBy($user), 403);

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')
            ->download($document->file_path, $document->file_name);
    }

    /**
     * Delete document
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $user = auth()->user();

        abort_unless(
            $document->uploaded_by === $user->id || $user->role === 'chairman',
            403
        );

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted.');
    }

    /**
     * Category → folder
     */
    private function folderFor(string $category): string
    {
        return match ($category) {
            'loans'     => 'loan_documents',
            'minutes'   => 'meeting_minutes',
            'members'   => 'member_files',
            'financial' => 'financial_reports',
            'policy'    => 'policies',
            default     => 'documents',
        };
    }
}
