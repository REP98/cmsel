<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => "Admin",
            'email' => 'admin@'.preg_replace('/([https|http]+\:\/\/)/m', '', env('APP_URL')),
            'password' => Hash::make('Webmaster18*/')
        ])->assignRole('SuperAdmin');

    }
}
