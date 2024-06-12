<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Seeder::call(RoleSeeder::class);
        Seeder::call(UserSeeder::class);
        Seeder::call(VehicleSeeader::class);
        Seeder::call(ContractServiceSeeder::class);
        Seeder::call(PatientSeeader::class);
        Seeder::call(HospitalSeeder::class);
        Seeder::call(EventSeeder::class);

    }
}
