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
        Schema::create('service_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('contact_name')->nullable();
            $table->integer('wheelchair')->default(0)->nullable();
            $table->integer('ambulatory')->default(0)->nullable();
            $table->integer('out_of_hours')->default(0)->nullable();
            $table->integer('saturdays')->default(0)->nullable();
            $table->integer('sundays_holidays')->default(0)->nullable();
            $table->integer('companion')->default(0)->nullable();
            $table->integer('additional_waiting')->default(0)->nullable(); 
            $table->integer('after')->default(0)->nullable();
            $table->integer('fast_track')->default(0)->nullable();
            $table->integer('if_not_cancel')->default(0)->nullable();
            $table->integer('rate_per_mile')->default(0)->nullable();
            $table->integer('overcharge')->default(0)->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('state')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_contracts');
    }
};
