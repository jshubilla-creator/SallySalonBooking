<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HomeServiceValidator
{
    private const ALLOWED_CITIES = ['Taguig', 'Pasig'];
    private const BASE_FEE = 100; // Base fee for home service
    private const PER_KM_RATE = 50; // Additional fee per kilometer
    private const SALON_COORDINATES = [
        'latitude' => 14.5329, // Replace with actual salon coordinates
        'longitude' => 121.0217 // Replace with actual salon coordinates
    ];

    public function validateCity(string $address): bool
    {
        foreach (self::ALLOWED_CITIES as $city) {
            if (Str::contains(strtolower($address), strtolower($city))) {
                return true;
            }
        }
        return false;
    }

    public function extractCity(string $address): ?string
    {
        foreach (self::ALLOWED_CITIES as $city) {
            if (Str::contains(strtolower($address), strtolower($city))) {
                return $city;
            }
        }
        return null;
    }

    public function calculateDistance(float $customerLat, float $customerLng): float
    {
        // Haversine formula to calculate distance in kilometers
        $earthRadius = 6371; // Earth's radius in kilometers

        $latDelta = deg2rad($customerLat - self::SALON_COORDINATES['latitude']);
        $lngDelta = deg2rad($customerLng - self::SALON_COORDINATES['longitude']);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad(self::SALON_COORDINATES['latitude'])) * cos(deg2rad($customerLat)) *
            sin($lngDelta / 2) * sin($lngDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }

    public function calculateFee(float $distanceKm): float
    {
        // Base fee plus per-kilometer rate
        return self::BASE_FEE + ($distanceKm * self::PER_KM_RATE);
    }

    public function getLocationCoordinates(string $address): ?array
    {
        try {
            // Using Nominatim OpenStreetMap API (consider using Google Maps API for production)
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'limit' => 1
            ]);

            if ($response->successful() && count($response->json()) > 0) {
                $location = $response->json()[0];
                return [
                    'latitude' => (float) $location['lat'],
                    'longitude' => (float) $location['lon']
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Error geocoding address: ' . $e->getMessage());
        }

        return null;
    }

    public function validateAndCalculateFee(string $address): array
    {
        $isValidCity = $this->validateCity($address);
        if (!$isValidCity) {
            return [
                'valid' => false,
                'message' => 'Home service is only available in Taguig and Pasig.',
                'fee' => 0,
                'distance_km' => 0,
                'city' => null
            ];
        }

        $coordinates = $this->getLocationCoordinates($address);
        if (!$coordinates) {
            return [
                'valid' => false,
                'message' => 'Unable to determine location coordinates.',
                'fee' => 0,
                'distance_km' => 0,
                'city' => $this->extractCity($address)
            ];
        }

        $distanceKm = $this->calculateDistance($coordinates['latitude'], $coordinates['longitude']);
        $fee = $this->calculateFee($distanceKm);

        return [
            'valid' => true,
            'message' => 'Location is valid for home service.',
            'fee' => $fee,
            'distance_km' => $distanceKm,
            'city' => $this->extractCity($address),
            'coordinates' => $coordinates
        ];
    }
}