<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('lessonNo')->unsigned();
            $table->string('lesson_name');
            $table->mediumText('description');
            $table->string('author');
            $table->integer('added_by')->unsigned();
            $table->foreign('added_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('last_updated_by')->unsigned();
            $table->foreign('last_updated_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        $table->dropForeign(['course_id']);
        $table->dropForeign(['added_by']);
        $table->dropForeign(['last_updated_by']);
        Schema::dropIfExists('lessons');
    }
}
