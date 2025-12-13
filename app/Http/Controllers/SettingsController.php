<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Show the settings page
     */
    public function index()
    {
        return view('settings');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone_number' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('settings')->with('success', 'Profile updated successfully');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        auth()->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('settings')->with('success', 'Password updated successfully');
    }

    /**
     * Update notification preferences
     */
    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'email_loan_updates' => 'nullable|boolean',
            'email_savings_updates' => 'nullable|boolean',
            'email_member_updates' => 'nullable|boolean',
            'email_reports' => 'nullable|boolean',
        ]);

        $preferences = [
            'notification_email_loans' => $request->has('email_loan_updates') ? 1 : 0,
            'notification_email_savings' => $request->has('email_savings_updates') ? 1 : 0,
            'notification_email_members' => $request->has('email_member_updates') ? 1 : 0,
            'notification_email_reports' => $request->has('email_reports') ? 1 : 0,
        ];

        auth()->user()->update($preferences);

        return redirect()->route('settings')->with('success', 'Notification preferences updated successfully');
    }

    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'Password is incorrect');
        }

        $user = auth()->user();
        
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Account deleted successfully');
    }
}
