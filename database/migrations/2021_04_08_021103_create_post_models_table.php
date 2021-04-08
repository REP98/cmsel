<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_type');
            $table->string('post_title');
            $table->string('post_slug');
            $table->json('post_img')->nullable();
            $table->integer('status_post')->default(1);
            $table->foreignId('post_categories');
            $table->foreignId('post_tags');
            $table->text('post_content')->nullable();
            $table->foreignId('post_autor')
                ->references('id')
                ->on('users')
                ->onUpdate('no action')
                ->onDelete('no action');
            $table->text('resumen_post');
            $table->foreignId('comment_status')->default(1);
            $table->index('post_slug');
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
        Schema::dropIfExists('posts');
    }
}
