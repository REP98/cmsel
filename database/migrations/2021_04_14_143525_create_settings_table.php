<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->json('image')->nulleable();
            $table->json('general')->nulleable();
            $table->json('config')->nulleable();
            $table->json('pages')->nulleable();
            $table->json('menu')->nulleable();
            $table->json('mail')->nulleable();
            $table->foreignId('style_id')->constrained('styles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
