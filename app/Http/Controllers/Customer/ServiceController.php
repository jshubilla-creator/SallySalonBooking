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
        $feedback = \App\Models\Feedback::whereHas('appointment', function($q) use ($service) {
            $q->where('service_id', $service->id);
        })->where('is_public', true)->with('user')->latest()->take(3)->get();
        
        return response()->json([
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'price' => $service->price,
            'duration_minutes' => $service->duration_minutes,
            'category' => $service->category,
            'feedback' => $feedback->map(function($f) {
                return [
                    'rating' => $f->rating,
                    'comment' => $f->comment,
                    'user_name' => $f->user->name,
                    'created_at' => $f->created_at->format('M d, Y')
                ];
            })
        ]);
    }
}
