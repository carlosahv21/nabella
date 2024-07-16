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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->integer('service_contract_id')->unsigned()->references('id')->on('service_contracts')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('birth_date');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('medicalid');
            $table->string('billing_code');
            $table->string('emergency_contact');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('observations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
