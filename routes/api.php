<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\HomeServiceValidator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/validate-address', function (Request $request, HomeServiceValidator $validator) {
        $request->validate([
            'address' => 'required|string'
        ]);

        return response()->json($validator->validateAndCalculateFee($request->address));
    });

    // Specialist posts current location (MVP)
    Route::post('/specialists/{specialist}/location', [\App\Http\Controllers\Api\SpecialistLocationController::class, 'update']);

    // Customers poll appointment location
    Route::get('/appointments/{appointment}/location', [\App\Http\Controllers\Api\AppointmentLocationController::class, 'show']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});