<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::findByName('admin');
        $employee = Role::findByName('employee');
        $permission1 = Permission::findByName('add employee');
        $permission2 = Permission::findByName('view employee');
        $permission3 = Permission::findByName('edit employee');

        // ASSIGN ADD, VIEW , EDIT
        $admin->givePermissionTo($permission1);
        $admin->givePermissionTo($permission2);
        $admin->givePermissionTo($permission3);

        // ASSIGN VIEW
        $employee->givePermissionTo($permission2);

    }
}
