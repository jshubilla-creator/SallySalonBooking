<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Specialist;
use Illuminate\Support\Facades\DB;

class SpecialistAppointmentsCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'specialist:counts {--show-samples}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show appointment counts per specialist and optional sample appointment IDs.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Specialist appointment counts:');

        $specialists = Specialist::orderBy('id')->get();

        $rows = [];

        foreach ($specialists as $s) {
            $count = DB::table('appointments')->where('specialist_id', $s->id)->count();
            $sample = '';
            if ($this->option('show-samples') && $count > 0) {
                $ids = DB::table('appointments')->where('specialist_id', $s->id)->limit(5)->pluck('id')->toArray();
                $sample = implode(',', $ids);
            }
            $rows[] = [
                'id' => $s->id,
                'name' => $s->name,
                'appointments_count' => $count,
                'sample_ids' => $sample,
            ];
        }

        $this->table(['ID', 'Name', 'Appointments', 'Sample IDs'], array_map(function($r){
            return [$r['id'], $r['name'], $r['appointments_count'], $r['sample_ids']];
        }, $rows));

        return 0;
    }
}
