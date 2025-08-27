<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('email', config('constants.admin.email'))->doesntExist()) {
            User::create([
                'first_name' => config('constants.admin.first_name'),
                'last_name' => config('constants.admin.last_name'),
                'email' => config('constants.admin.email'),
                'password' => bcrypt(config('constants.admin.password')),
                'mobile_number' => config('constants.admin.mobile_number'),
                'status' => 1, // Active
                'confirmation_flag' => true,
                'registration_complete' => true,
            ]);
        }
    }
}
