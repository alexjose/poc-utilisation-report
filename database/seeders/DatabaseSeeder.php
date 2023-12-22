<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

            Unit::create([
                'org_id' => 1,
                'name' => 'test1',
                'code' => 'test1',
                'level' => 1,
                'parent_unit_id' => null,
                'heirarchy' => null,
                'heirarchy_json' => [],
            ]);

            Unit::create([
                'org_id' => 1,
                'name' => 'test2',
                'code' => 'test2',
                'level' => 2,
                'parent_unit_id' => 1,
                'heirarchy' => '1.',
                'heirarchy_json' => [1],
            ]);


    }
}
