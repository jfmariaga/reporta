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
        $role2 = Role::create(['name' => 'JefeArea']);
        $role3 = Role::create(['name' => 'JefeImpacto']);

        Permission::create(['name'=> 'home'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=> 'gestion'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name'=> 'area'])->syncRoles([$role1]);
        Permission::create(['name'=> 'impacto'])->syncRoles([$role1]);
        Permission::create(['name'=> 'panal'])->syncRoles([$role1]);
        Permission::create(['name'=> 'reportador'])->syncRoles([$role1]);
        Permission::create(['name'=> 'usuarios'])->syncRoles([$role1]);
    }
}
