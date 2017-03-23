<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP8ConversationFillWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p8_conversation_fill_words', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('dialogNo')->unsigned();
            $table->tinyInteger('lineNo')->unsigned();
            $table->string('line');
            $table->string('answer')->nullable();
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
        Schema::dropIfExists('p8_conversation_fill_words');
    }
}
