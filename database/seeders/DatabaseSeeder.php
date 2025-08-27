<?php

namespace Database\Seeders;

use Database\Seeders\Module\WellbeingPillarSeeder;
use Database\Seeders\Module\WellnessInterestSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            WellnessInterestSeeder::class,
            WellbeingPillarSeeder::class,
        ]);
    }
}
