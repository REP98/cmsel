<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->json('description');
            $table->text('content');
            $table->foreignId('parent_id')->nulleable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('page_style', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('style_id');

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');

            $table->foreign('style_id')
                ->references('id')
                ->on('styles')
                ->onDelete('cascade');
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
        Schema::dropIfExists('page_style');
        Schema::dropIfExists('pages');
    }
}
