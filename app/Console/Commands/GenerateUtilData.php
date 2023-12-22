<?php

namespace App\Console\Commands;

use App\Models\Unit;
use App\Models\UnitCount;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;

class GenerateUtilData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-util-data {--from= : From date} {--to= : To date}';

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
        $from = $this->option('from') ? Carbon::parse($this->option('from')) : today()->subMonth(3)->startOfMonth();
        $to = $this->option('to') ? Carbon::parse($this->option('to')) : today()->subMonth(1)->endOfMonth();

        

        $this->info("Generating data from {$from} to {$to}");

        $period = CarbonPeriod::since($from)->days(20)->until($to);

        foreach ($period as $date) {
            $newPeriod[] = $date;
        }

        $count = count($newPeriod);

        for ($i = 0; $i < $count - 1; $i++) {
            $countFrom = $newPeriod[$i];
            $countTo = $newPeriod[$i + 1]->copy()->subDay();
            $this->line("Generating data from {$countFrom} to {$countTo}");
            $countPeriod = CarbonPeriod::since($countFrom)->until($countTo);
            $pool = Process::pool(function ($pool) use ($countPeriod) {
                foreach ($countPeriod as $date) {
                    $pool->command('php artisan app:gen-util-data ' . $date->toDateString())->forever();
                }
            })
            ->start(function (string $type, string $output, int $key) {
                // ...
            });
            $results = $pool->wait();
        }
    }

    
}
