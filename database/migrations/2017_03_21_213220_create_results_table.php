<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('learner')->unsigned();
            $table->foreign('learner')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('lesson_id')->unsigned();
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->double('P2_point');
            $table->double('P4_point');
            $table->double('P6_point');
            $table->double('P8_point');
            $table->double('P9_point');
            $table->double('P10_point');
            $table->double('P11_point');
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
        $table->dropForeign(['learner']);
        $table->dropForeign(['lesson_id']);
        Schema::dropIfExists('results');
    }
}
