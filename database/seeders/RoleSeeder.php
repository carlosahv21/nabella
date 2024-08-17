<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Driver']);

        Permission::create(['name' => 'user.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'user.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'user.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'user.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'role.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'role.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'role.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'role.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'driver.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'driver.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'driver.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'driver.delete'])->syncRoles([$role1]);                

        Permission::create(['name' => 'vehicle.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'vehicle.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'vehicle.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'vehicle.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'facility.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'facility.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'facility.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'facility.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'servicecontract.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'servicecontract.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'servicecontract.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'servicecontract.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'patient.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'patient.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'patient.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'patient.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'scheduling.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'scheduling.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'scheduling.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'scheduling.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'report.view'])->syncRoles([$role1]);
        Permission::create(['name' => 'report.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'report.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'report.delete'])->syncRoles([$role1]);

        Permission::create(['name' => 'dashboard.view'])->syncRoles([$role1],$role2);
    }
}
