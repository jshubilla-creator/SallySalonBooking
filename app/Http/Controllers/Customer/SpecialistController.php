<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SpecialistController extends Controller
{
    public function index()
    {
        $specialists = Specialist::available()->with('services')->get();
        return view('customer.specialists.index', compact('specialists'));
    }

    public function show(Specialist $specialist)
    {
        return response()->json([
            'id' => $specialist->id,
            'name' => $specialist->name,
            'email' => $specialist->email,
            'phone' => $specialist->phone,
            'bio' => $specialist->bio,
            'specialization' => $specialist->specialization,
            'experience_years' => $specialist->experience_years,
            'working_hours' => [
                'monday' => ['enabled' => '1', 'start' => '09:00', 'end' => '17:00'],
                'tuesday' => ['enabled' => '1', 'start' => '09:00', 'end' => '17:00'],
                'wednesday' => ['enabled' => '1', 'start' => '09:00', 'end' => '17:00'],
                'thursday' => ['enabled' => '1', 'start' => '09:00', 'end' => '17:00'],
                'friday' => ['enabled' => '1', 'start' => '09:00', 'end' => '17:00'],
                'saturday' => ['enabled' => '0', 'start' => '09:00', 'end' => '17:00'],
                'sunday' => ['enabled' => '0', 'start' => '09:00', 'end' => '17:00']
            ],
            'services' => [
                ['id' => 1, 'name' => 'Haircut', 'price' => '200.00']
            ],
            'is_busy_now' => false,
            'busy_reason' => null,
            'feedback' => []
        ]);
    }
}
