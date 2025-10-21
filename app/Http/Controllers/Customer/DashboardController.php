<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirect managers and admins to their own dashboards
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('manager')) {
            return redirect()->route('manager.dashboard');
        }

        // ✅ Use direct Appointment query (avoids cached relation)
        $appointments = Appointment::with(['service', 'specialist'])
            ->where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact('appointments'));
    }
}
