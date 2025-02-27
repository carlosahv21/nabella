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
        Schema::table('schedulings', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('end_date');
        });

        Schema::table('service_contracts', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('date_end');
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('date_end');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('email_verified_at');
        });

        Schema::table('facilities', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('service_contract_id');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('user_id');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
