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
        Schema::table('scheduling_charge', function (Blueprint $table) {
            $table->boolean('cane')->default(false)->nullable()->after('flat_rate');
            $table->boolean('walker')->default(false)->nullable()->after('cane');
            $table->boolean('bchair')->default(false)->nullable()->after('walker');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scheduling_charge', function (Blueprint $table) {
            //
        });
    }
};
