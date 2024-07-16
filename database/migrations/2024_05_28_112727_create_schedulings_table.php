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
            $table->bigIncrements('id');
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('hospital_id');
            $table->unsignedInteger('driver_id');
            $table->unsignedInteger('driver_return_id'); // Nuevo campo para el conductor del viaje de vuelta
            $table->string('distance');
            $table->string('duration');
            $table->date('date');
            $table->string('check_in');
            $table->string('pick_up');
            $table->string('pick_up_time');
            $table->string('status')->default('Waiting');
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
