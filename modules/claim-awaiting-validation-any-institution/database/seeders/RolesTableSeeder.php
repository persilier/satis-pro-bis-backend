<?php

namespace Satis2020\ClaimAwaitingValidationAnyInstitution\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Satis2020\ServicePackage\Models\Metadata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Satis2020\ServicePackage\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

        // create permissions
        $permission_list = Permission::create(['name' => 'list-claim-awaiting-validation-any-institution', 'guard_name' => 'api']);
        $permission_show = Permission::create(['name' => 'show-claim-awaiting-validation-any-institution', 'guard_name' => 'api']);
        $permission_validate = Permission::create(['name' => 'validate-treatment-any-institution', 'guard_name' => 'api']);

        if ($nature === 'DEVELOP') {
            // create admin roles
            $role_pilot = Role::where('name', 'pilot')->where('guard_name', 'api')->firstOrFail();

            $role_pilot->givePermissionTo([
                $permission_list, $permission_show, $permission_validate
            ]);
        }

        if ($nature == 'HUB') {
            $role_pilot = Role::where('name', 'pilot')->where('guard_name', 'api')->firstOrFail();

            $role_pilot->givePermissionTo([
                $permission_list, $permission_show, $permission_validate
            ]);
        }

    }
}
