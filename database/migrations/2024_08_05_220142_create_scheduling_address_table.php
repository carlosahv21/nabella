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
            $table->unsignedInteger('scheduling_id')->nullable();
            $table->unsignedInteger('driver_id')->nullable();
            $table->string('pick_up_address')->nullable();
            $table->string('drop_off_address')->nullable();
            $table->string('pick_up_hour')->nullable();
            $table->string('drop_off_hour')->nullable();
            $table->string('distance')->nullable();
            $table->string('duration')->nullable();
            $table->string('type_of_trip')->nullable();
            $table->string('status')->nullable();
            $table->string('observations')->nullable();

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