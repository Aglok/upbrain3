<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->increments('id');

            $table->tinyInteger('user_id');
            $table->string('stage', 60);
            $table->tinyInteger('task_id');
            $table->tinyInteger('experience');
            $table->tinyInteger('gold');
            $table->string('rating');
            $table->text('comment');
            $table->tinyInteger('number_lesson');

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
        Schema::drop('processes');
    }
}
