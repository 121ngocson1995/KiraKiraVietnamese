<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP5DialogueMemorizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p5_dialogue_memorizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('dialogNo')->unsigned();
            $table->string('dialog');
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
        Schema::dropIfExists('p5_dialogue_memorizes');
    }
}
