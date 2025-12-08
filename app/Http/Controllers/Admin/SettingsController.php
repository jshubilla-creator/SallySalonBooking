<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Services\SettingsService;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $settingsService = new SettingsService();
        $defaults = [
            'salon_name' => config('app.name', 'Salon Booking System'),
            'salon_address' => '123 Main Street, City, State 12345',
            'salon_phone' => '+1 (555) 123-4567',
            'salon_email' => 'info@salon.com',
        ];

        $settings = array_replace_recursive($defaults, $settingsService->all());

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'salon_name' => 'required|string|max:255',
            'salon_email' => 'required|email|max:255',
            'salon_phone' => 'required|string|max:20',
            'salon_address' => 'required|string|max:500',
        ]);

        $settingsService = new SettingsService();
        $settingsService->setMany($request->only(['salon_name', 'salon_email', 'salon_phone', 'salon_address']));

        Log::info('General settings updated', $request->only(['salon_name', 'salon_email']));

        return redirect()->route('admin.settings')
            ->with('success', 'General settings updated successfully.');
    }



    /**
     * ✅ Clear all Laravel caches (config, route, view, etc.)
     */
    public function clearCache()
    {
        try {
            // Clear all possible caches
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('optimize:clear');
            
            // Clear compiled views
            if (File::exists(storage_path('framework/views'))) {
                array_map('unlink', glob(storage_path('framework/views/*')));
            }

            // Log cache clearing
            Log::info('Application cache cleared successfully');
            
            return back()->with('success', '✅ All application caches cleared successfully.');
        } catch (\Exception $e) {
            Log::error('Cache clearing failed', ['error' => $e->getMessage()]);
            return back()->with('error', '⚠️ Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Create a full database backup (.sql file in /storage/backups)
     */
    /**
     * Create a comprehensive backup of the system
     */
    public function backupNow()
    {
        try {
            // Check if ZIP extension is loaded
            if (!extension_loaded('zip')) {
                $instructions = "PHP ZIP extension is not enabled. Please follow these steps:\n\n";
                $instructions .= "1. Open C:\\xampp\\php\\php.ini\n";
                $instructions .= "2. Find the line ;extension=zip\n";
                $instructions .= "3. Remove the semicolon (;) at the start of the line\n";
                $instructions .= "4. Save the file\n";
                $instructions .= "5. Restart your Apache server in XAMPP\n\n";
                $instructions .= "After completing these steps, try the backup again.";
                
                Log::error('ZIP extension not loaded', ['error' => $instructions]);
                return back()->with('error', '⚠️ ZIP extension not enabled. Check system logs for instructions.');
            }
            $backupPath = storage_path('backups');
            $date = Carbon::now()->format('Y-m-d_H-i-s');
            $backupFolder = $backupPath . '/backup_' . $date;

            // Create backup directories
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }
            File::makeDirectory($backupFolder, 0755, true);

            // Clean old backups (keep only last 7 days)
            $oldBackups = File::directories($backupPath);
            foreach ($oldBackups as $oldBackup) {
                if (Carbon::createFromTimestamp(File::lastModified($oldBackup))->diffInDays() > 7) {
                    File::deleteDirectory($oldBackup);
                }
            }

            // 1. Database Backup
            $dbFilename = 'database.sql';
            $dbFilePath = $backupFolder . '/' . $dbFilename;

            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $database = config('database.connections.mysql.database');
            $host = config('database.connections.mysql.host', '127.0.0.1');
            $port = config('database.connections.mysql.port', '3306');

            // First, try to locate mysqldump
            $mysqldumpPath = '';
            $possiblePaths = [
                'C:\xampp\mysql\bin\mysqldump.exe',
                'C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe',
                'C:\wamp\bin\mysql\mysql8.0.31\bin\mysqldump.exe',
                'mysqldump'
            ];

            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $mysqldumpPath = $path;
                    break;
                }
            }

            if (empty($mysqldumpPath)) {
                // If no mysqldump found in common locations, try to find it in PATH
                $output = [];
                exec('where mysqldump', $output, $resultCode);
                if ($resultCode === 0 && !empty($output)) {
                    $mysqldumpPath = trim($output[0]);
                }
            }

            if (empty($mysqldumpPath)) {
                throw new \Exception('mysqldump executable not found. Please check if MySQL is properly installed.');
            }

            // Create a temporary file for MySQL credentials
            $cnfFile = $backupFolder . '/temp.cnf';
            $cnfContent = sprintf(
                "[client]\nhost = %s\nport = %s\nuser = %s\npassword = %s",
                $host,
                $port,
                $username,
                $password
            );
            File::put($cnfFile, $cnfContent);

            // Build the command with the config file
            $command = sprintf(
                '"%s" --defaults-extra-file="%s" --add-drop-table --add-locks --extended-insert --single-transaction --quick --routines --triggers --events %s > "%s"',
                $mysqldumpPath,
                $cnfFile,
                escapeshellarg($database),
                $dbFilePath
            );

            $output = null;
            $resultCode = null;
            
            // Execute the command and capture both output and errors
            $descriptorspec = array(
                1 => array("pipe", "w"),  // stdout
                2 => array("pipe", "w")   // stderr
            );
            
            $process = proc_open($command, $descriptorspec, $pipes);
            
            if (is_resource($process)) {
                $stdout = stream_get_contents($pipes[1]);
                $stderr = stream_get_contents($pipes[2]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                $resultCode = proc_close($process);
            }

            // Clean up the temporary config file
            if (File::exists($cnfFile)) {
                File::delete($cnfFile);
            }

            // Check if the backup was successful
            if ($resultCode !== 0 || !File::exists($dbFilePath) || File::size($dbFilePath) === 0) {
                $errorMessage = !empty($stderr) ? $stderr : (!empty($stdout) ? $stdout : 'Unknown error occurred');
                throw new \Exception('Database backup failed: ' . $errorMessage);
            }

            if ($resultCode !== 0) {
                throw new \Exception('Database backup failed: ' . implode("\n", $output));
            }

            // 2. Files Backup (important directories)
            $dirsToBackup = [
                'storage/app/public',    // User uploaded files
                'storage/logs',          // System logs
                'public/uploads',        // Public uploads if any
            ];

            foreach ($dirsToBackup as $dir) {
                $source = base_path($dir);
                if (File::exists($source)) {
                    $destination = $backupFolder . '/' . $dir;
                    File::makeDirectory(dirname($destination), 0755, true, true);
                    File::copyDirectory($source, $destination);
                }
            }

            // 3. Create backup info file
            $infoContent = [
                'Backup Date: ' . Carbon::now()->toDateTimeString(),
                'System Version: ' . config('app.version', '1.0.0'),
                'PHP Version: ' . PHP_VERSION,
                'Database: ' . $database,
                'Backed up directories: ' . implode(', ', $dirsToBackup),
                'Created by: ' . auth()->user()->name
            ];
            
            File::put($backupFolder . '/backup-info.txt', implode("\n", $infoContent));

            // 4. Create ZIP archive
            $zipFileName = 'backup_' . $date . '.zip';
            $zip = new \ZipArchive();
            
            if ($zip->open($backupPath . '/' . $zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($backupFolder),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($backupFolder) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                
                $zip->close();
                
                // Remove the temporary backup folder after creating ZIP
                File::deleteDirectory($backupFolder);
                
                // Log successful backup
                Log::info('System backup created successfully', [
                    'file' => $zipFileName,
                    'size' => File::size($backupPath . '/' . $zipFileName)
                ]);

                return response()->download(
                    $backupPath . '/' . $zipFileName,
                    $zipFileName,
                    ['Content-Type: application/zip']
                )->deleteFileAfterSend(true);
            }

            throw new \Exception('Failed to create ZIP archive');

        } catch (\Exception $e) {
            if (isset($backupFolder) && File::exists($backupFolder)) {
                File::deleteDirectory($backupFolder); // Clean up on failure
            }
            Log::error('Backup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', '⚠️ Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * ✅ View recent activity logs
     */
    public function activityLog()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            return back()->with('error', 'No log file found.');
        }

        $logs = File::get($logPath);
        
        // Parse logs into a more readable format
        $logEntries = collect(explode("\n", $logs))
            ->filter()
            ->map(function ($line) {
                if (preg_match('/\[(?<date>.*)\] (?<env>\w+)\.(?<type>\w+): (?<message>.*)/', $line, $matches)) {
                    return [
                        'date' => Carbon::parse($matches['date'])->format('Y-m-d H:i:s'),
                        'type' => $matches['type'],
                        'message' => $matches['message']
                    ];
                }
                return null;
            })
            ->filter()
            ->take(100); // Get last 100 entries

        return view('admin.activity-log', ['logs' => $logEntries]);
    }
}
