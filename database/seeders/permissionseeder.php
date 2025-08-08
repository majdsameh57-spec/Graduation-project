<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Permission::create(['name' => 'Create-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Permission', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Create-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Admin', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Edit-User-Permission', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-User-Permission', 'guard_name' => 'admin']);


        Permission::create(['name' => 'Create-Product', 'guard_name' => 'merchant']);
        Permission::create(['name' => 'Read-Products', 'guard_name' => 'merchant']);
        Permission::create(['name' => 'Read-Products', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Shop', 'guard_name' => 'merchant']);
        Permission::create(['name' => 'Update-Shop', 'guard_name' => 'merchant']);
        Permission::create(['name' => 'Delete-Shop', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Branch', 'guard_name' => 'merchant']);
        Permission::create(['name' => 'Delete-Branch', 'guard_name' => 'merchant']);

        Permission::create(['name' => 'Update-Product', 'guard_name' => 'merchant']);
        Permission::create(['name' => 'Delete-Product', 'guard_name' => 'admin']);


        Permission::create(['name' => 'Delete-Branch', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Merchants', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Create-Merchant', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Merchant', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Merchant', 'guard_name' => 'admin']);

    }
}
