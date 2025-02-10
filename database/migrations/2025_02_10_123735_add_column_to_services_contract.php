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
        Schema::table('service_contracts', function (Blueprint $table) {
            $table->integer('cane')->default(0)->nullable()->after('overcharge');
            $table->integer('walker')->default(0)->nullable()->after('cane');
            $table->integer('bchair')->default(0)->nullable()->after('walker');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_contracts', function (Blueprint $table) {
            //
        });
    }
};
