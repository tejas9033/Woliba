<?php

namespace Database\Seeders\Module;

use App\Enums\Status;
use App\Models\WellnessInterest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WellnessInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (WellnessInterest::count() == 0) {

            $interests = ['Yoga', 'Meditation', 'Fitness', 'Nutrition', 'Sleep', 'Mindfulness', 'Breathwork'];
            foreach ($interests as $interest) {
                WellnessInterest::create(['name' => $interest, 'status' => Status::ACTIVE->value]);
            }
        }
    }
}
