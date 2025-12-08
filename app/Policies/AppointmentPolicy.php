<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id || $user->hasRole(['admin', 'manager']);
    }

    public function update(User $user, Appointment $appointment)
    {
        // Only allow updates if:
        // 1. User owns the appointment and it's not completed/cancelled
        // 2. User is admin/manager
        return ($user->id === $appointment->user_id && !in_array($appointment->status, ['completed', 'cancelled']))
            || $user->hasRole(['admin', 'manager']);
    }

    public function delete(User $user, Appointment $appointment)
    {
        // Only allow cancellation if:
        // 1. User owns the appointment and it's not completed/cancelled
        // 2. User is admin/manager
        return ($user->id === $appointment->user_id && !in_array($appointment->status, ['completed', 'cancelled']))
            || $user->hasRole(['admin', 'manager']);
    }
}