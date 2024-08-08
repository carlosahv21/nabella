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
        Schema::create('scheduling_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('scheduling_id');
            $table->unsignedInteger('driver_id');
            $table->string('pick_up_address');
            $table->string('drop_off_address');
            $table->string('pick_up_hour');
            $table->string('drop_off_hour');
            $table->string('distance');
            $table->string('duration');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduling_address');
    }
};