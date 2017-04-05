<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageCulturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_cultures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('extensionNo')->unsigned();
            $table->tinyInteger('type')->unsigned();
                /*
                *  0: culture
                *  1: song
                *  2: poem
                *  3: idiom
                *  4: riddle
                *  5: game
                */
            $table->string('title')->nullable();
            $table->mediumText('content');
            $table->string('thumbnail')->nullable();
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            $table->text('slideshow_caption')->nullable();
            $table->text('slideshow_images')->nullable();
            $table->string('song_composer')->nullable();
            $table->string('song_performer')->nullable();
            $table->string('riddle_answer')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['lesson_id']);
        Schema::dropIfExists('language_cultures');
    }
}
