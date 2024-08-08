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
            $table->string('contact_name');
            $table->integer('wheelchair')->default(0);
            $table->integer('ambulatory')->default(0);
            $table->integer('out_of_hours')->default(0);
            $table->integer('saturdays')->default(0);
            $table->integer('sundays_holidays')->default(0);
            $table->integer('companion')->default(0);
            $table->integer('additional_waiting')->default(0); 
            $table->integer('after')->default(0);
            $table->integer('fast_track')->default(0);
            $table->integer('if_not_cancel')->default(0);
            $table->integer('rate_per_mile')->default(0);
            $table->integer('overcharge')->default(0);
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('state');
            $table->date('date_start');
            $table->date('date_end');
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
