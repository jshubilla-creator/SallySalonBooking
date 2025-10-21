<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();
        return view('customer.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        return response()->json([
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'price' => $service->price,
            'duration_minutes' => $service->duration_minutes,
            'category' => $service->category,
        ]);
    }
}
