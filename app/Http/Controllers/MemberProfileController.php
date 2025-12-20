<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load(['documents', 'nextOfKin', 'savings']);
        
        $accountSummary = [
            'member_since' => $user->created_at->format('d M Y'),
            'membership_status' => $user->status === 'active' ? 'Active' : ucfirst($user->status),
            'total_savings' => $user->savings ? $user->savings->available_savings : 0,
            'active_loans' => $user->loans()->where('status', 'active')->sum('amount') ?? 0,
        ];
        
        $loanEligibility = ($user->savings->available_savings ?? 0) * 1.5;
        
        return view('member.profile', compact('user', 'accountSummary', 'loanEligibility'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'national_id' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'monthly_salary' => 'nullable|numeric|min:0',
            'employment_date' => 'nullable|date',
            'update_employment' => 'nullable',
            'update_nok' => 'nullable',
            'next_of_kin_name' => 'nullable|string|max:255',
            'next_of_kin_relationship' => 'nullable|string|max:50',
            'next_of_kin_phone' => 'nullable|string|max:20',
            'next_of_kin_id_number' => 'nullable|string|max:20',
            'next_of_kin_address' => 'nullable|string|max:255',
        ]);
        
        // Update personal information
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'national_id' => $data['national_id'],
            'date_of_birth' => $data['date_of_birth'],
            'address' => $data['address'],
        ]);
        
        // Update employment info if requested
        if ($request->has('update_employment')) {
            $user->update([
                'department' => $data['department'],
                'position' => $data['position'],
                'monthly_salary' => $data['monthly_salary'],
                'employment_date' => $data['employment_date'],
            ]);
        }
        
        // Update next of kin if requested
        if ($request->has('update_nok') && $user->nextOfKin) {
            $user->nextOfKin->update([
                'name' => $data['next_of_kin_name'],
                'relationship' => $data['next_of_kin_relationship'],
                'phone' => $data['next_of_kin_phone'],
                'national_id' => $data['next_of_kin_id_number'],
                'address' => $data['next_of_kin_address'],
            ]);
        }
        
        return redirect()->route('member.profile')->with('success', 'Profile updated successfully!');
    }
    
    public function updatePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    $user = Auth::user();
    
    // Delete old profile picture if exists
    if ($user->profile_picture) {
        // Remove 'storage/' prefix if it exists
        $oldPath = str_replace('storage/', '', $user->profile_picture);
        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
    }
    
    // Store new profile picture
    $path = $request->file('profile_picture')->store('profile-pictures', 'public');
    
    $user->update([
        'profile_picture' => 'storage/' . $path, // Add 'storage/' prefix for web access
    ]);
    
    return redirect()->route('member.profile')->with('success', 'Profile picture updated successfully!');
}
}