<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP3SentenceMemorizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p3_sentence_memorizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('sentenceNo')->unsigned();
            $table->string('sentence');
            $table->string('audio');
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
        Schema::dropIfExists('p3_sentence_memorizes');
    }
}
