<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialist;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class SpecialistLocationController extends Controller
{
    /**
     * Update specialist current location.
     */
    public function update(Request $request, Specialist $specialist): JsonResponse
    {
        // basic permission: must be an authenticated manager/admin or a specialist
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // allow managers/admins to update any specialist
        if ($user->hasRole('manager') || $user->hasRole('admin')) {
            // allowed
        } elseif ($user->hasRole('specialist')) {
            // If there's no direct user_id link between User and Specialist in the schema,
            // fall back to matching on contact info (email or phone). This is a reasonable
            // inference for this project; if you'd prefer a strict user_id foreign key,
            // we can add a migration to link them instead.
            $matchesEmail = $user->email && $specialist->email && strtolower($user->email) === strtolower($specialist->email);
            $matchesPhone = $user->phone && $specialist->phone && preg_replace('/\D+/', '', $user->phone) === preg_replace('/\D+/', '', $specialist->phone);
            if (! $matchesEmail && ! $matchesPhone) {
                return response()->json(['message' => 'Forbidden: you may only update your own specialist location'], 403);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $data = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'appointment_id' => 'nullable|integer|exists:appointments,id',
        ]);

        $specialist->current_lat = $data['latitude'];
        $specialist->current_lng = $data['longitude'];
        $specialist->location_updated_at = now();
        $specialist->save();

        if (!empty($data['appointment_id'])) {
            $appointment = Appointment::find($data['appointment_id']);
            if ($appointment && $appointment->is_home_service) {
                $appointment->latitude = $data['latitude'];
                $appointment->longitude = $data['longitude'];
                $appointment->save();
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
