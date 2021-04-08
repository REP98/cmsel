<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesModelsTable extends Migration
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
            $table->foreignId('parent_id')->nullable();
            $table->string('title');
            $table->string('description');
            $table->text('content');
            $table->index('slug');
            $table->foreignId('page_autor')
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
        Schema::dropIfExists('pages');
    }
}
