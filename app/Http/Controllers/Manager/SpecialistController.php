<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use App\Models\Service;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialist::with('services');

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        // Filter by specialization
        if ($request->has('specialization') && $request->specialization !== '') {
            $query->where('specialization', $request->specialization);
        }

        // Filter by availability
        if ($request->has('availability') && $request->availability !== '') {
            $query->where('is_available', $request->availability === 'available');
        }

        $specialists = $query->orderBy('name')->paginate(10);
        $specializations = Specialist::distinct()->pluck('specialization')->filter();

        return view('manager.specialists.index', compact('specialists', 'specializations'));
    }

    public function create()
    {
        $services = Service::active()->get();
        return view('manager.specialists.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:specialists,email',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'working_hours' => 'required|array',
            'is_available' => 'boolean',
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        $specialist = Specialist::create($request->except('services'));

        if ($request->has('services')) {
            $specialist->services()->attach($request->services);
        }

        return redirect()->route('manager.specialists.index')
            ->with('success', 'Specialist created successfully.');
    }

    public function show(Specialist $specialist)
    {
        $specialist->load(['services', 'appointments.user', 'appointments.service']);
        return view('manager.specialists.show', compact('specialist'));
    }

    public function edit(Specialist $specialist)
    {
        $services = Service::active()->get();
        $specialist->load('services');
        return view('manager.specialists.edit', compact('specialist', 'services'));
    }

    public function update(Request $request, Specialist $specialist)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:specialists,email,' . $specialist->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'working_hours' => 'required|array',
            'is_available' => 'boolean',
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        $specialist->update($request->except('services'));

        if ($request->has('services')) {
            $specialist->services()->sync($request->services);
        }

        return redirect()->route('manager.specialists.index')
            ->with('success', 'Specialist updated successfully.');
    }

    public function destroy(Specialist $specialist)
    {
        $specialist->delete();
        return redirect()->route('manager.specialists.index')
            ->with('success', 'Specialist deleted successfully.');
    }
}
