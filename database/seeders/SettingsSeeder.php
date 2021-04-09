<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;


class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
        	'img' => json_encode([
        		'logo' => 'img/artpost.svg',
        		'avatar' => 'img/avatarwithmask.png'
        	]),
        	'config' => json_encode([
        		'title' => 'ArtPost',
        		'descriptions' => ''
        	]),
        	'mail' => '[]',
    		'style' => '[]'
        ]);
    }
}
