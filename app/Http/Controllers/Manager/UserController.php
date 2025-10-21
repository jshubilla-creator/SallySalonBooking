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
        if ($request->has('gender') && $request->gender !== '') {
            $query->where('gender', $request->gender);
        }

        $users = $query->orderBy('name')->paginate(10);
        $genders = ['male', 'female', 'other'];

        return view('manager.users.index', compact('users', 'genders'));
    }

    public function show(User $user)
    {
        $user->load(['appointments.service', 'appointments.specialist']);
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
}
