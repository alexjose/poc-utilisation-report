<?php

namespace App\Console\Commands;

use App\Models\UnitCount;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenUtilData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gen-util-data {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $unitCount;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::parse($this->argument('date'));

        $this->unitCount = DB::table('units')->count();

        $this->generateCounts($date);
    }

    public function generateCounts($date)
    {

        info("Generating data for {$date->toDateString()}");
        DB::table('units')->orderBy('id')
            ->lazy()
            ->each(function ($unit) use ($date) {
                if ($unit->id % 10000 == 0) {
                    info("Seeding Counts for "
                        . $date->toDateString()
                        . " "
                        . intval($unit->id / $this->unitCount * 100)
                        . "%");
                }
                $count = rand(100, 9999);
                UnitCount::create([
                    'unit_id' => $unit->id,
                    'created_at' => $date,
                    'count' => $count
                ]);
            });
    }
}
