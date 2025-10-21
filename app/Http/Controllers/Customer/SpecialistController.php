<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    public function index()
    {
        $specialists = Specialist::available()->with('services')->get();
        return view('customer.specialists.index', compact('specialists'));
    }

    public function show(Specialist $specialist)
    {
        $specialist->load('services');
        return response()->json([
            'id' => $specialist->id,
            'name' => $specialist->name,
            'email' => $specialist->email,
            'phone' => $specialist->phone,
            'bio' => $specialist->bio,
            'specialization' => $specialist->specialization,
            'experience_years' => $specialist->experience_years,
            'working_hours' => $specialist->working_hours,
            'services' => $specialist->services->map(function($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => $service->price,
                ];
            }),
        ]);
    }
}
