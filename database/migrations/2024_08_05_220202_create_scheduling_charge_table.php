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
        Schema::create('scheduling_charge', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('scheduling_id');
            $table->string('type_of_trip');
            $table->boolean('wheelchair')->default(false);
            $table->boolean('ambulatory')->default(false);
            $table->boolean('out_of_hours')->default(false);
            $table->boolean('saturdays')->default(false);
            $table->boolean('sundays_holidays')->default(false);
            $table->boolean('companion')->default(false);
            $table->boolean('aditional_waiting')->default(false);
            $table->boolean('fast_track')->default(false);
            $table->boolean('if_not_cancel')->default(false);
            $table->boolean('overcharge')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduling_charge');
    }
};
