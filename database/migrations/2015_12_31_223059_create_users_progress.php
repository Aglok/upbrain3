<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersProgress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('progress_id');
            $table->tinyInteger('user_id');
            $table->tinyInteger('experience');
            $table->text('description');
            $table->tinyInteger('gift');
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
        //Schema::drop('users_progress');
    }
}
