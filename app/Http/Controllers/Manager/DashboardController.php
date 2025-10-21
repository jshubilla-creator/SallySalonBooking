<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ✅ Today's Appointments
        $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();

        // ✅ Pending Appointments
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        // ✅ Today's Revenue (sum of completed appointments for today)
        $todayRevenue = Appointment::whereDate('appointment_date', $today)
            ->where('status', 'completed')
            ->sum('total_price');

        // ✅ Total Customers
        $totalCustomers = User::role('customer')->count();

        // ✅ Recent Appointments
        $recentAppointments = Appointment::with(['user', 'service', 'specialist'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ✅ Low Stock Items
        $lowStockItems = Inventory::whereRaw('quantity <= min_quantity')->count();

        // ✅ Weekly Appointments
        $weekStart = $today->copy()->startOfWeek();
        $weekEnd = $today->copy()->endOfWeek();
        $weekAppointments = Appointment::whereBetween('appointment_date', [$weekStart, $weekEnd])
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return view('manager.dashboard', compact(
            'todayAppointments',
            'pendingAppointments',
            'todayRevenue',
            'totalCustomers',
            'recentAppointments',
            'lowStockItems',
            'weekAppointments'
        ));
    }
}
