<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_default_value = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        $superadmin = User::create(array_merge([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@latihanlaravel.com'

        ], $user_default_value));

        $sales = User::create(array_merge([
            'name' => 'Sales',
            'email' => 'sales@latihanlaravel.com'

        ], $user_default_value));

        $purchase = User::create(array_merge([
            'name' => 'Purchase ',
            'email' => 'purchase@latihanlaravel.com'

        ], $user_default_value));
        $manager = User::create(array_merge([
            'name' => 'Manager ',
            'email' => 'manager@latihanlaravel.com'

        ], $user_default_value));
        /**create role */
        $role_superadmin = Role::create(['name' => 'SuperAdmin']);
        $role_sales = Role::create(['name' => 'Sales']);
        $role_purchase = Role::create(['name' => 'Purchase']);
        $role_manager = Role::create(['name' => 'Manager']);
        /** create permission */
        $permission = Permission::create(['name' => 'read purchase']);
        $permission = Permission::create(['name' => 'create purchase']);
        $permission = Permission::create(['name' => 'update purchase']);
        $permission = Permission::create(['name' => 'delete purchase']);

        $permission = Permission::create(['name' => 'read sales']);
        $permission = Permission::create(['name' => 'create sales']);
        $permission = Permission::create(['name' => 'update sales']);
        $permission = Permission::create(['name' => 'delete sales']);

        $permission = Permission::create(['name' => 'read inventory']);
        $permission = Permission::create(['name' => 'create inventory']);
        $permission = Permission::create(['name' => 'update inventory']);
        $permission = Permission::create(['name' => 'delete inventory']);
        $permission = Permission::create(['name' => 'print purchase']);
        $permission = Permission::create(['name' => 'print sales']);


        /** role permission superadmin */
        $role_superadmin->givePermissionTo('read purchase');
        $role_superadmin->givePermissionTo('read sales');
        $role_superadmin->givePermissionTo('read inventory');
        $role_superadmin->givePermissionTo('create purchase');
        $role_superadmin->givePermissionTo('create sales');
        $role_superadmin->givePermissionTo('create inventory');
        $role_superadmin->givePermissionTo('update purchase');
        $role_superadmin->givePermissionTo('update sales');
        $role_superadmin->givePermissionTo('update inventory');
        $role_superadmin->givePermissionTo('delete purchase');
        $role_superadmin->givePermissionTo('delete sales');
        $role_superadmin->givePermissionTo('delete inventory');

        /**role permission sales */
        $role_sales->givePermissionTo('read sales');
        $role_sales->givePermissionTo('create sales');
        $role_sales->givePermissionTo('update sales');
        $role_sales->givePermissionTo('delete sales');

        /**role permission purchase  */
        $role_purchase->givePermissionTo('read purchase');
        $role_purchase->givePermissionTo('create purchase');
        $role_purchase->givePermissionTo('update purchase');
        $role_purchase->givePermissionTo('delete purchase');
        /**role permission manager  */
        $role_manager->givePermissionTo('read purchase');
        $role_manager->givePermissionTo('read sales');
        $role_manager->givePermissionTo('read inventory');
        $role_manager->givePermissionTo('print purchase');
        $role_manager->givePermissionTo('print sales');
        /**asign role  */
        $superadmin->assignRole('SuperAdmin');
        $sales->assignRole('Sales');
        $purchase->assignRole('Purchase');
        $manager->assignRole('Manager');
    }
}
