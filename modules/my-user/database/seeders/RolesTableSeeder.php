<?php

namespace Satis2020\MyUser\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Satis2020\ServicePackage\Models\Metadata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class RolesTableSeeder
 * @package Satis2020\MyUser\Database\Seeders
 */
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Role::flushEventListeners();

        $nature = env('APP_NATURE');

        // create staff from any unit permissions
        $permission_list = Permission::create(['name' => 'list-user-my-institution', 'guard_name' => 'api']);
        $permission_store = Permission::create(['name' => 'store-user-my-institution', 'guard_name' => 'api']);
        $permission_show = Permission::create(['name' => 'show-user-my-institution', 'guard_name' => 'api']);

        if ($nature === 'DEVELOP') {
            // get role admin
            $role_admin = Role::where('name', 'admin-filial')->where('guard_name', 'api')->firstOrFail();

            // associate permissions to roles
            $role_admin->givePermissionTo([
                $permission_list, $permission_store, $permission_show
            ]);

        }

        if ($nature === 'MACRO') {
            // create admin roles
            $role_admin_filial = Role::where('name', 'admin-filial')->where('guard_name', 'api')->firstOrFail();

            // associate permissions to roles
            $role_admin_filial->givePermissionTo([
                $permission_list, $permission_store, $permission_show
            ]);

        }

        if ($nature === 'PRO') {
            // create admin roles
            $role_admin_pro = Role::where('name', 'admin-pro')->where('guard_name', 'api')->firstOrFail();

            // associate permissions to roles
            $role_admin_pro->givePermissionTo([
                $permission_list, $permission_store, $permission_show
            ]);

        }

    }
}
