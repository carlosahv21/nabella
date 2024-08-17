<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('make');
            $table->string('model');
            $table->string('vin');
            $table->integer('number_vehicle');
            $table->integer('user_id')->unsigned()->references('id')->on('users')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
