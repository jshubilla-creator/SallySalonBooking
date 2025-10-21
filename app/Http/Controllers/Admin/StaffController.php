<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of staff members.
     */
    public function index(Request $request): View
    {
        // Staff query
        $staffQuery = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['manager', 'admin']);
        })->with('roles');

        // Staff search
        if ($request->has('staff_search') && $request->staff_search !== '') {
            $search = $request->staff_search;
            $staffQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Staff role filter
        if ($request->has('staff_role') && $request->staff_role !== '') {
            $staffQuery->whereHas('roles', function($query) use ($request) {
                $query->where('name', $request->staff_role);
            });
        }



        
        $staff = $staffQuery->orderBy('name')->paginate(10);

        // Specialists query
        $specialistsQuery = Specialist::with('services');

        // Specialists search
        if ($request->has('specialist_search') && $request->specialist_search !== '') {
            $search = $request->specialist_search;
            $specialistsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Specialists specialization filter
        if ($request->has('specialist_specialization') && $request->specialist_specialization !== '') {
            $specialistsQuery->where('specialization', $request->specialist_specialization);
        }

        $specialists = $specialistsQuery->orderBy('name')->paginate(10);

        $staffRoles = ['manager', 'admin'];
        $specializations = Specialist::distinct()->pluck('specialization')->filter();

        return view('admin.staff.index', compact('staff', 'specialists', 'staffRoles', 'specializations'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create(): View
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created staff member.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'role' => ['required', 'in:manager,admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Display the specified staff member.
     */
    public function show(User $staff): View
    {
        $staff->load('roles');
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(User $staff): View
    {
        $staff->load('roles');
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member.
     */
    public function update(Request $request, User $staff): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($staff->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'role' => ['required', 'in:manager,admin'],
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        // Update role if changed
        if (!$staff->hasRole($request->role)) {
            $staff->syncRoles([$request->role]);
        }

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified staff member.
     */
    public function destroy(User $staff): RedirectResponse
    {
        // Prevent deleting the last admin
        if ($staff->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->route('admin.staff.index')
                ->with('error', 'Cannot delete the last admin user.');
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    /**
     * Show the form for creating a new specialist.
     */
    public function createSpecialist(): View
    {
        $services = \App\Models\Service::where('is_active', true)->get();
        return view('admin.staff.create-specialist', compact('services'));
    }

    /**
     * Store a newly created specialist.
     */
    public function storeSpecialist(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:specialists'],
            'phone' => ['required', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'specialization' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'working_hours' => ['required', 'array'],
            'working_hours.*.day' => ['required', 'string', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'working_hours.*.start_time' => ['required', 'string'],
            'working_hours.*.end_time' => ['required', 'string'],
            'working_hours.*.is_available' => ['boolean'],
            'services' => ['required', 'array'],
            'services.*' => ['exists:services,id'],
        ]);

        $specialist = Specialist::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'working_hours' => $request->working_hours,
            'is_available' => true,
        ]);

        $specialist->services()->sync($request->services);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Specialist created successfully.');
    }

    /**
     * Show the form for editing the specified specialist.
     */
    public function editSpecialist(Specialist $specialist): View
    {
        $services = \App\Models\Service::where('is_active', true)->get();
        $specialist->load('services');
        return view('admin.staff.edit-specialist', compact('specialist', 'services'));
    }

    /**
     * Update the specified specialist.
     */
    public function updateSpecialist(Request $request, Specialist $specialist): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('specialists')->ignore($specialist->id)],
            'phone' => ['required', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'specialization' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'working_hours' => ['required', 'array'],
            'working_hours.*.day' => ['required', 'string', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'working_hours.*.start_time' => ['required', 'string'],
            'working_hours.*.end_time' => ['required', 'string'],
            'working_hours.*.is_available' => ['boolean'],
            'services' => ['required', 'array'],
            'services.*' => ['exists:services,id'],
            'is_available' => ['boolean'],
        ]);

        $specialist->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'working_hours' => $request->working_hours,
            'is_available' => $request->boolean('is_available'),
        ]);

        $specialist->services()->sync($request->services);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Specialist updated successfully.');
    }

    /**
     * Remove the specified specialist.
     */
    public function destroySpecialist(Specialist $specialist): RedirectResponse
    {
        $specialist->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Specialist deleted successfully.');
    }
}
