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
            $table->string('type_of_trip')->nullable();
            $table->boolean('wheelchair')->default(false)->nullable();
            $table->boolean('ambulatory')->default(false)->nullable();
            $table->boolean('out_of_hours')->default(false)->nullable();
            $table->boolean('saturdays')->default(false)->nullable();
            $table->boolean('sundays_holidays')->default(false)->nullable();
            $table->boolean('companion')->default(false)->nullable();
            $table->boolean('aditional_waiting')->default(false)->nullable();
            $table->boolean('fast_track')->default(false)->nullable();
            $table->boolean('if_not_cancel')->default(false)->nullable();
            $table->boolean('collect_cancel')->default(false)->nullable();
            $table->boolean('overcharge')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('scheduling_charge');
    }
};
