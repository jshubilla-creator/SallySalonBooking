<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Specialist;
use App\Services\HomeServiceValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    protected $homeServiceValidator;

    public function __construct(HomeServiceValidator $homeServiceValidator)
    {
        $this->homeServiceValidator = $homeServiceValidator;
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $appointments = Appointment::with(['service', 'specialist'])
            ->where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::all();
        $specialists = Specialist::all();
        return view('appointments.create', compact('services', 'specialists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'specialist_id' => 'required|exists:specialists,id',
            'appointment_date' => 'required|date|after:today',
            'start_time' => 'required',
            'is_home_service' => 'boolean',
            'home_address' => 'required_if:is_home_service,1',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
        ]);

        try {
            DB::beginTransaction();

            $service = Service::findOrFail($request->service_id);
            $data = $request->all();
            $data['user_id'] = Auth::id();
            $data['status'] = 'pending';
            $data['total_price'] = $service->price;

            // Handle home service validation and fee calculation
            if ($request->is_home_service) {
                $homeServiceDetails = $this->homeServiceValidator->validateAndCalculateFee($request->home_address);
                
                if (!$homeServiceDetails['valid']) {
                    return back()->withErrors(['home_address' => $homeServiceDetails['message']])->withInput();
                }

                $data['city'] = $homeServiceDetails['city'];
                $data['distance_km'] = $homeServiceDetails['distance_km'];
                $data['distance_fee'] = $homeServiceDetails['fee'];
                $data['latitude'] = $homeServiceDetails['coordinates']['latitude'];
                $data['longitude'] = $homeServiceDetails['coordinates']['longitude'];
                
                // Calculate grand total (service price + distance fee)
                $data['grand_total'] = $service->price + $homeServiceDetails['fee'];
            } else {
                $data['grand_total'] = $service->price;
            }

            // Calculate end time based on service duration
            $startTime = \Carbon\Carbon::parse($request->start_time);
            $data['end_time'] = $startTime->copy()->addMinutes($service->duration);

            // Check specialist availability
            $conflictingAppointment = Appointment::where('specialist_id', $request->specialist_id)
                ->where('appointment_date', $request->appointment_date)
                ->where(function ($query) use ($startTime, $data) {
                    $query->whereBetween('start_time', [$startTime, $data['end_time']])
                        ->orWhereBetween('end_time', [$startTime, $data['end_time']]);
                })->first();

            if ($conflictingAppointment) {
                return back()->withErrors(['start_time' => 'The specialist is not available at this time.'])->withInput();
            }

            $appointment = Appointment::create($data);

            DB::commit();

            return redirect()->route('appointments.show', $appointment)
                ->with('success', 'Appointment created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating appointment: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error creating appointment. Please try again.'])->withInput();
        }
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $services = Service::all();
        $specialists = Specialist::all();
        return view('appointments.edit', compact('appointment', 'services', 'specialists'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'specialist_id' => 'required|exists:specialists,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'is_home_service' => 'boolean',
            'home_address' => 'required_if:is_home_service,1',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
        ]);

        try {
            DB::beginTransaction();

            $service = Service::findOrFail($request->service_id);
            $data = $request->all();
            $data['total_price'] = $service->price;

            // Handle home service validation and fee calculation
            if ($request->is_home_service) {
                $homeServiceDetails = $this->homeServiceValidator->validateAndCalculateFee($request->home_address);
                
                if (!$homeServiceDetails['valid']) {
                    return back()->withErrors(['home_address' => $homeServiceDetails['message']])->withInput();
                }

                $data['city'] = $homeServiceDetails['city'];
                $data['distance_km'] = $homeServiceDetails['distance_km'];
                $data['distance_fee'] = $homeServiceDetails['fee'];
                $data['latitude'] = $homeServiceDetails['coordinates']['latitude'];
                $data['longitude'] = $homeServiceDetails['coordinates']['longitude'];
                
                // Calculate grand total (service price + distance fee)
                $data['grand_total'] = $service->price + $homeServiceDetails['fee'];
            } else {
                $data['grand_total'] = $service->price;
                // Reset home service fields
                $data['city'] = null;
                $data['distance_km'] = null;
                $data['distance_fee'] = null;
                $data['latitude'] = null;
                $data['longitude'] = null;
            }

            // Calculate end time based on service duration
            $startTime = \Carbon\Carbon::parse($request->start_time);
            $data['end_time'] = $startTime->copy()->addMinutes($service->duration);

            // Check specialist availability (excluding current appointment)
            $conflictingAppointment = Appointment::where('specialist_id', $request->specialist_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('id', '!=', $appointment->id)
                ->where(function ($query) use ($startTime, $data) {
                    $query->whereBetween('start_time', [$startTime, $data['end_time']])
                        ->orWhereBetween('end_time', [$startTime, $data['end_time']]);
                })->first();

            if ($conflictingAppointment) {
                return back()->withErrors(['start_time' => 'The specialist is not available at this time.'])->withInput();
            }

            $appointment->update($data);

            DB::commit();

            return redirect()->route('appointments.show', $appointment)
                ->with('success', 'Appointment updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating appointment: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error updating appointment. Please try again.'])->withInput();
        }
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        try {
            DB::beginTransaction();
            $appointment->delete();
            DB::commit();

            return redirect()->route('appointments.index')
                ->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling appointment: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error cancelling appointment. Please try again.']);
        }
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'specialist_id' => 'required|exists:specialists,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'service_id' => 'required|exists:services,id'
        ]);

        $service = Service::findOrFail($request->service_id);
        $startTime = \Carbon\Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $isAvailable = !Appointment::where('specialist_id', $request->specialist_id)
            ->where('appointment_date', $request->appointment_date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })->exists();

        return response()->json(['available' => $isAvailable]);
    }
}