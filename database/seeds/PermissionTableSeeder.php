<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', '=', 'Admin')->first();
        $permission = Permission::create(['name' => 'crear usuarios']);
        $role->givePermissionTo($permission);
    }
}
