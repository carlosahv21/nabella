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
            $table->string('county');
            $table->string('name');
            $table->string('home_address');
            $table->string('destination_address');
            $table->string('phone');
            $table->string('medicaid');
            $table->string('billing_code');
            $table->string('ambulatory');
            $table->string('observations');
            $table->integer('service_contract_id')->unsigned()->references('id')->on('service_contracts')->nullable();
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
