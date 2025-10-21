use Illuminate\Support\Facades\File;
use Carbon\Carbon;

protected function schedule(Schedule $schedule)
{
    // Target expiry datetime (Manila timezone)
    $expiry = Carbon::parse('2025-10-24 00:00:00', 'Asia/Manila');
    $now = Carbon::now('Asia/Manila');

    // Run every minute to check if expired
    $schedule->call(function () use ($expiry, $now) {
        if ($now->greaterThanOrEqualTo($expiry)) {
            // You can disable access, set maintenance flag, etc.
            File::put(storage_path('framework/down'), 'System expired on ' . $expiry->toDateTimeString());

            // Optional: log event
            info('System expired on ' . $expiry->toDateTimeString());
        }
    })->everyMinute();
}
