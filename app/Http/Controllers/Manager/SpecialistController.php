<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\SpecialistHoursUpdatedNotification;
use Illuminate\Support\Facades\Notification;

class SpecialistController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialist::with('services');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%")
                  ->orWhereHas('services', function($serviceQuery) use ($search) {
                      $serviceQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('category', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        // Filter by availability
        if ($request->filled('availability')) {
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
            'profile_image' => 'nullable|url|max:500',
            'working_hours' => 'required|array',
            'is_available' => 'boolean',
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        // Normalize phone number before saving
        $data = $request->except('services');
        if (!empty($data['phone'])) {
            $phone = preg_replace('/[^0-9+]/', '', $data['phone']);
            if (preg_match('/^0[0-9]{9}$/', $phone)) {
                $phone = '+63' . substr($phone, 1);
            }
            $data['phone'] = $phone;
        }

        $specialist = Specialist::create($data);

        if ($request->has('services')) {
            $specialist->services()->attach($request->services);
        }

        return redirect()->route('manager.specialists.index')
            ->with('success', 'Specialist created successfully.');
    }

    public function show(Specialist $specialist)
    {
        // Load services and recent appointments and include a count to use in the UI
        $specialist->load(['services', 'appointments.user', 'appointments.service']);
        $specialist->loadCount('appointments');
        return view('manager.specialists.show', compact('specialist'));
    }

    public function fetch($id)
    {
        $specialist = Specialist::find($id);
        
        if (!$specialist) {
            return response()->json(['error' => 'Specialist not found'], 404);
        }

        return response()->json([
            'id' => $specialist->id,
            'name' => $specialist->name,
            'bio' => $specialist->bio,
            'specialization' => $specialist->specialization,
            'experience_years' => $specialist->experience_years
        ]);
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
            'profile_image' => 'nullable|url|max:500',
            'working_hours' => 'required|array',
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        // Prepare the base data
        $data = $request->except(['services', 'is_available', 'availability_changed']);
        if (!empty($data['phone'])) {
            $phone = preg_replace('/[^0-9+]/', '', $data['phone']);
            if (preg_match('/^0[0-9]{9}$/', $phone)) {
                $phone = '+63' . substr($phone, 1);
            }
            $data['phone'] = $phone;
        }
        
        // Update the main data
        $specialist->fill($data);
        
        // Only update availability if the checkbox was interacted with
        if ($request->input('availability_changed') === '1') {
            \Log::info('Updating availability', [
                'specialist_id' => $specialist->id,
                'previous_value' => $specialist->is_available,
                'new_value' => $request->has('is_available')
            ]);
            $specialist->is_available = $request->has('is_available');
        }
        
        $specialist->save();

        if ($request->has('services')) {
            $specialist->services()->sync($request->services);
        }

        // Notify admin and customers about hours update
        $admins = User::role('admin')->get();
        $customers = User::role('customer')->get();
        
        Notification::send($admins, new SpecialistHoursUpdatedNotification($specialist, 'Manager'));
        Notification::send($customers, new SpecialistHoursUpdatedNotification($specialist, 'Manager'));

        return redirect()->route('manager.specialists.index')
            ->with('success', 'Specialist updated successfully. Notifications sent to admin and customers.');
    }

    public function destroy(Specialist $specialist)
    {
        $specialist->delete();
        return redirect()->route('manager.specialists.index')
            ->with('success', 'Specialist deleted successfully.');
    }



}