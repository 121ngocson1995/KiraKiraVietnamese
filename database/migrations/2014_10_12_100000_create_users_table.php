<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->boolean('gender')->nullable();
            $table->string('password');
            $table->date('date_of_birth')->nullable();
            $table->string('avatar')->default('public/img/avatar_2x.png');
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->unsignedTinyInteger('role')->default(0);
            /*
            *  0: learner
            *  1: teacher
            *  2: admin
            *  100: super admin
            */
            $table->foreign('role')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->rememberToken();
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
        $table->dropForeign(['role']);
        Schema::dropIfExists('users');
    }
}
