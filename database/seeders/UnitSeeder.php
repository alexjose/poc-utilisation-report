<?php

namespace Database\Seeders;

use App\Models\Unit;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Monolog\Level;

class UnitSeeder extends Seeder
{
    public $faker;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->faker = Factory::create();
        // $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
        $totalCount = 0;
        for ($level = 0; $level < 6; $level++) {
            dump("Seeding " . $level + 1 . " Units, Memory: " . memory_get_peak_usage(true) / 1024 / 1024 . "MB");
            $limit = min(pow(5, $level * 2), 10 * 10 * 10000) - $totalCount;
            dump("Level: " . $level + 1 . ", Limit: " . $limit);
            $this->insertUnits($level, $limit);
            $totalCount += $limit;
        }
    }

    function insertUnits($level, $limit)
    {
        for ($i = 0; $i < $limit; $i++) {
            if ($i % 10000 == 0) {
                dump("Seeding "
                    . $level + 1
                    . " Units ("
                    .  intval($i / $limit * 100)
                    . "%), Memory: "
                    . memory_get_peak_usage(true) / 1024 / 1024
                    . "MB");
                if ($level) {
                    $parents = Unit::where('level', $level)
                        ->select('heirarchy_json', 'id')
                        ->inRandomOrder()
                        ->take(10000)
                        ->get();
                }
            }

            if (isset($parents) && $parents->isNotEmpty()) {
                $parent = $parents->random();
                $heirarchy = $parent->heirarchy_json;
                array_push($heirarchy, $parent->id);
            }

            Unit::create([
                'org_id' => 1,
                'name' => $this->faker->name,
                'code' => $this->faker->uuid,
                'level' => $level + 1,
                'parent_unit_id' => isset($parent) ? $parent->id : null,
                'heirarchy' => isset($heirarchy) ? implode('.', $heirarchy) . '.' : '',
                'heirarchy_json' => $heirarchy ?? [],
            ]);
        }
    }
}
