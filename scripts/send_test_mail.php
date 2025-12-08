<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Change this ID to an existing user ID you want to test sending to
$testUserId = 6;

$user = App\Models\User::find($testUserId);
if (! $user) {
    echo "User with id {$testUserId} not found\n";
    exit(1);
}

try {
    \Illuminate\Support\Facades\Mail::raw("Test email from the application to {$user->email}. Hello {$user->name}", function ($m) use ($user) {
        $m->to($user->email)
          ->subject('Test Email from SalonBookngMs');
    });

    echo "Mail send attempted to {$user->email}\n";
} catch (Throwable $e) {
    echo "Error sending mail: " . $e->getMessage() . "\n";
}
