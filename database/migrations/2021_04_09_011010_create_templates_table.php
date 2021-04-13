<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shotcode');
            $table->string('position')->nullable();
            $table->json('content')->nullable();
            $table->json('ids')->nullable();
            $table->json('type_id')->nullable();
            $table->json('config')->nullable();
            $table->string('slug');
            $table->foreignId('style_id');
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('no action')
                ->onDelete('no action');
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
        Schema::dropIfExists('templates');
    }
}
