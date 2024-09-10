<?php

namespace Database\Seeders;

use App\Models\SchedulingAutoagend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SchedulingAutoagendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchedulingAutoagend::create([
            'id' => 1
        ]);
    }
}
