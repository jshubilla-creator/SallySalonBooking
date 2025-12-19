<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function getVariations(Service $service)
    {
        return response()->json([
            'variations' => $service->variations ?? []
        ]);
    }
}