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
            $table->float('flat_rate')->default(0)->nullable()->after('overcharge');
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
