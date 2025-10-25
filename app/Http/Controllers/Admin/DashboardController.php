<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAppointments = Appointment::count();
        $activeServices = Service::where('is_active', true)->count();

        // Get only paid appointments (amount_paid not null and greater than 0)
        $paidAppointments = Appointment::whereNotNull('amount_paid')
            ->where('amount_paid', '>', 0);

        // Revenue calculations based on amount_paid only
        $totalRevenue = $paidAppointments->sum('amount_paid');

        $dailyRevenue = (clone $paidAppointments)
            ->whereDate('updated_at', Carbon::today())
            ->sum('amount_paid');

        $weeklyRevenue = (clone $paidAppointments)
            ->whereBetween('updated_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->sum('amount_paid');

        $monthlyRevenue = (clone $paidAppointments)
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->sum('amount_paid');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAppointments',
            'activeServices',
            'totalRevenue',
            'dailyRevenue',
            'weeklyRevenue',
            'monthlyRevenue'
        ));
    }
}
