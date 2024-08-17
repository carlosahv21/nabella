<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->date('dob');
            $table->string('dl_state');
            $table->string('dl_number');
            $table->string('date_of_hire');
            $table->string('phone');
            $table->string('address');
            $table->string('emergency_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at');
            $table->string('location');
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
