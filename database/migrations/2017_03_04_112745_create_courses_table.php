<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('thumbnail');
            $table->string('name');
            $table->mediumText('description');
            $table->tinyInteger('age')->nullable();
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
        $table->dropForeign(['added_by']);
        $table->dropForeign(['last_updated_by']);
        Schema::dropIfExists('courses');
    }
}
