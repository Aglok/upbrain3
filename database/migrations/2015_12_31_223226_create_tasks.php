<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('number_task');
            $table->string('image');
            $table->tinyInteger('experience');
            $table->tinyInteger('gold');
            $table->string('grade');
            $table->tinyInteger('subject_id');
            $table->string('answer');
            $table->string('detail');
            $table->tinyInteger('set_of_task');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //  Schema::drop('tasks');
    }
}
