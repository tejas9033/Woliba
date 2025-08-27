<?php

namespace Database\Seeders\Module;

use App\Enums\Status;
use App\Models\WellbeingPillar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WellbeingPillarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (WellbeingPillar::count() == 0) {

            $pillars = ['Physical', 'Mental', 'Social', 'Financial', 'Emotional'];
            foreach ($pillars as $pillar) {
                WellbeingPillar::create(['name' => $pillar, 'status' => Status::ACTIVE->value]);
            }
        }
    }
}
