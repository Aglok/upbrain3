<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
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

            $table->string('email', 120);
            $table->string('password', 60);

            $table->string('name', 30);
            $table->string('surname', 30);
            $table->string('login', 30);
            $table->tinyInteger('group');
            $table->string('description', 300);

            $table->tinyInteger('logins')->default(0);
            $table->tinyInteger('last_login')->nullable();

            $table->string('avatar', 100)->nullable();

            $table->rememberToken();
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
        //Schema::drop('users');
    }
}
