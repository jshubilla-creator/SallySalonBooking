<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Daily Booking Limits
    |--------------------------------------------------------------------------
    |
    | Configure the maximum number of appointments that can be booked per day.
    |
    */
    'daily_booking_limit' => env('SALON_DAILY_BOOKING_LIMIT', 20),
    
    /*
    |--------------------------------------------------------------------------
    | Business Hours
    |--------------------------------------------------------------------------
    |
    | Configure the salon's operating hours.
    |
    */
    'business_hours' => [
        'start' => '09:00',
        'end' => '18:00',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Booking Settings
    |--------------------------------------------------------------------------
    |
    | Additional booking configuration options.
    |
    */
    'advance_booking_days' => env('SALON_ADVANCE_BOOKING_DAYS', 30),
    'cancellation_hours' => env('SALON_CANCELLATION_HOURS', 24),
];