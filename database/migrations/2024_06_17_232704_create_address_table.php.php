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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id(); // Esto crea una columna 'id' con auto_increment
            $table->enum('entity_type', ['Patient', 'Facility']);
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->string('address');
            $table->timestamps();

            // Definir las llaves foráneas manualmente con nombres únicos
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('facility_id')->references('id')->on('facilities');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('addresses');
    }
};
