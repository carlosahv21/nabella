<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::create([
            'name' => 'Root',
            'email' => 'root@material.com',
            'password' => ('secret')
        ])->assignRole('Admin');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('name', 'Root')->delete();
    }
};
