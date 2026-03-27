<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * View User List (Super Admin Only)
     */
    public function index()
    {
        // The email address has been standardized to match your current account.
        if (auth()->user()->email !== 'aboodasfour@gmail.com') {
            abort(403, 'Access Denied: Only the Super Admin can manage staff permissions.');
        }

        $users = User::orderBy('name')->get();
        return view('staff.index', compact('users'));
    }

    /**
     * * Converting the user to admin or vice versa
     */
    public function toggleAdmin(User $user)
    {
        // The email address has also been standardized here
        if (auth()->user()->email !== 'aboodasfour@gmail.com') {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Critical Alert: You cannot revoke your own Super Admin access!');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->route('staff.index')->with('success', 'User status updated successfully.');
    }
}