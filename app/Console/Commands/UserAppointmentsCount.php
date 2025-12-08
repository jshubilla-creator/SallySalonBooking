<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserAppointmentsCount extends Command
{
    protected $signature = 'user:counts {--show-samples}';
    protected $description = 'Show appointment counts per user and optional sample appointment IDs.';

    public function handle(): int
    {
        $this->info('User appointment counts:');

        $users = User::role('customer')->orderBy('id')->get();

        $rows = [];
        foreach ($users as $u) {
            $count = DB::table('appointments')->where('user_id', $u->id)->count();
            $sample = '';
            if ($this->option('show-samples') && $count > 0) {
                $ids = DB::table('appointments')->where('user_id', $u->id)->limit(5)->pluck('id')->toArray();
                $sample = implode(',', $ids);
            }
            $rows[] = [
                'id' => $u->id,
                'name' => $u->name,
                'appointments_count' => $count,
                'sample_ids' => $sample,
            ];
        }

        $this->table(['ID','Name','Appointments','Sample IDs'], array_map(function($r){
            return [$r['id'],$r['name'],$r['appointments_count'],$r['sample_ids']];
        }, $rows));

        return 0;
    }
}
