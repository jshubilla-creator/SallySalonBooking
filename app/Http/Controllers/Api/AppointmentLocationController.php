<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentLocationController extends Controller
{
    /**
     * Return the current location information for an appointment.
     */
    public function show(Appointment $appointment)
    {
        $specialist = $appointment->specialist;

        return response()->json([
            'appointment' => [
                'id' => $appointment->id,
                'latitude' => $appointment->latitude,
                'longitude' => $appointment->longitude,
            ],
            'specialist' => $specialist ? [
                'id' => $specialist->id,
                'name' => $specialist->name,
                'latitude' => $specialist->current_lat,
                'longitude' => $specialist->current_lng,
                'updated_at' => $specialist->location_updated_at,
            ] : null,
        ]);
    }
}
