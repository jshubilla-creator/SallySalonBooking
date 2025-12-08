<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('customer');

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by gender
        if ($request->filled('gender') && $request->gender !== '') {
            $query->where('gender', $request->gender);
        }

    // Include appointments count for the users index so the UI shows accurate counts
    $users = $query->withCount('appointments')->orderBy('name')->paginate(10);
        $genders = ['male', 'female', 'other'];

        return view('manager.users.index', compact('users', 'genders'));
    }

    public function show(User $user)
    {
        $user->load(['appointments.service', 'appointments.specialist']);
        // Load appointments count for reliable stats in the view
        $user->loadCount('appointments');
        return view('manager.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($request->all());

        return back()->with('success', 'User updated successfully.');
    }

    public function ban(Request $request, User $user)
    {
        $request->validate([
            'ban_reason' => 'required|string|max:500',
        ]);

        $user->ban($request->ban_reason);

        return back()->with('success', 'User has been banned successfully.');
    }

    public function unban(User $user)
    {
        $user->unban();

        return back()->with('success', 'User has been unbanned successfully.');
    }
}
