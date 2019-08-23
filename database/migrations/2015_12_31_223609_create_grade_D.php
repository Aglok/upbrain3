<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeD extends Migration
{
    public function up()
    {
        Schema::create('grade_D', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('subject_id');
            $table->tinyInteger('user_id');
            $table->tinyInteger('sum');
            $table->tinyInteger('full');
            $table->tinyInteger('time');
            $table->tinyInteger('number_lesson');
            $table->tinyInteger('experience');
            $table->tinyInteger('gold');
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
        //Schema::drop('grade_D');
    }
}
