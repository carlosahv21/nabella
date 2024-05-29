<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedulings', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->unsigned()->references('id')->on('patients')->nullable();
            $table->integer('servicecontract_id')->unsigned()->references('id')->on('service_contracts')->nullable();
            $table->integer('hospital_id')->unsigned()->references('id')->on('hospitals')->nullable();
            $table->boolean('auto_agend')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulings');
    }
};
