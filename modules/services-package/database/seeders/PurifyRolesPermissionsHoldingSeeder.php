<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PurifyRolesPermissionsHoldingSeeder extends Seeder
{

    public function addInstitutionTypeToRole($roleName, $institutionType)
    {
        $role = Role::where("name", $roleName)->where("guard_name", "api")->first();

        if (is_null($role)) {
            return json_encode([$institutionType]);
        }

        $institution_types = is_null($role->institution_types)
            ? []
            : json_decode($role->institution_types);

        if (!in_array($institutionType, $institution_types)) {
            array_push($institution_types, $institutionType);
        }

        return json_encode($institution_types);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nature = Config::get('services.app_nature', 'PRO');

        if ($nature === 'MACRO') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            $holdingRoles = [
                "admin-holding" => [
                    'list-any-institution', 'store-any-institution', 'update-any-institution', 'destroy-any-institution', 'show-any-institution',
                    'list-category-client', 'store-category-client', 'update-category-client', 'destroy-category-client', 'show-category-client',
                    'list-channel', 'store-channel', 'update-channel', 'destroy-channel', 'show-channel',
                    'list-claim-category', 'store-claim-category', 'update-claim-category', 'destroy-claim-category', 'show-claim-category',
                    'list-claim-object', 'store-claim-object', 'update-claim-object', 'destroy-claim-object', 'show-claim-object',
                    'update-claim-object-requirement',
                    'list-client-from-any-institution', 'store-client-from-any-institution', 'update-client-from-any-institution', 'destroy-client-from-any-institution', 'show-client-from-any-institution',
                    'show-mail-parameters', 'update-mail-parameters',
                    'show-sms-parameters', 'update-sms-parameters',
                    'list-currency', 'store-currency', 'update-currency', 'destroy-currency', 'show-currency',
                    'show-dashboard-data-all-institution',
                    'list-faq-category', 'store-faq-category', 'update-faq-category', 'destroy-faq-category', 'show-faq-category',
                    'list-message-apis', 'store-message-apis', 'update-message-apis', 'destroy-message-apis', 'update-institution-message-api', 'update-my-institution-message-api',
                    'list-position', 'store-position', 'update-position', 'destroy-position', 'show-position',
                    'list-unit-type', 'store-unit-type', 'update-unit-type', 'destroy-unit-type', 'show-unit-type',
                    'list-any-unit', 'store-any-unit', 'update-any-unit', 'destroy-any-unit', 'show-any-unit',
                    'list-category-client-from-my-institution', 'store-category-client-from-my-institution', 'update-category-client-from-my-institution', 'destroy-category-client-from-my-institution', 'show-category-client-from-my-institution',
                    'update-notifications',
                    'list-performance-indicator', 'store-performance-indicator', 'update-performance-indicator', 'destroy-performance-indicator', 'show-performance-indicator', 'edit-performance-indicator',
                    'update-processing-circuit-any-institution',
                    'list-severity-level', 'update-severity-level', 'show-severity-level',
                    'list-staff-from-any-unit', 'store-staff-from-any-unit', 'update-staff-from-any-unit', 'destroy-staff-from-any-unit', 'show-staff-from-any-unit', 'edit-staff-from-any-unit',
                    'list-account-type', 'show-account-type', 'update-account-type', 'store-account-type', 'destroy-account-type',
                    'list-user-any-institution', 'show-user-any-institution', 'store-user-any-institution',
                    'list-delai-qualification-parameters', 'show-delai-qualification-parameters', 'store-delai-qualification-parameters', 'destroy-delai-qualification-parameters',
                    'list-delai-treatment-parameters', 'show-delai-treatment-parameters', 'store-delai-treatment-parameters', 'destroy-delai-treatment-parameters',
                    'update-components-parameters',
                    'list-any-institution-type-role', 'show-any-institution-type-role', 'store-any-institution-type-role', 'update-any-institution-type-role', 'destroy-any-institution-type-role',
                    'update-active-pilot',
                    'update-recurrence-alert-settings',
                    'update-reject-unit-transfer-parameters',
                    'update-min-fusion-percent-parameters',
                    'update-relance-parameters',
                    'update-measure-preventive-parameters',
                    'show-faq', 'store-faq', 'update-faq', 'delete-faq',
                    'search-claim-any-reference',
                    'list-any-notification-proof',
                    'list-reporting-titles-configs','update-reporting-titles-configs','edit-reporting-titles-configs',
                ],
                "pilot-holding" => [
                    'list-claim-awaiting-assignment', 'show-claim-awaiting-assignment', 'merge-claim-awaiting-assignment',
                    'store-claim-against-any-institution',
                    'list-claim-awaiting-validation-my-institution', 'show-claim-awaiting-validation-my-institution', 'validate-treatment-my-institution',
                    'list-satisfaction-measured-my-claim', 'update-satisfaction-measured-my-claim',
                    'show-dashboard-data-all-institution', 'show-dashboard-data-my-institution',
                    'list-my-discussions', 'list-discussion-contributors', 'contribute-discussion',
                    'list-monitoring-claim-any-institution',
                    'list-reporting-claim-any-institution',
                    'transfer-claim-to-circuit-unit',
                    'transfer-claim-to-targeted-institution',
                    'list-claim-incomplete-against-any-institution', 'show-claim-incomplete-against-any-institution', 'update-claim-incomplete-against-any-institution',
                    'list-any-claim-archived', 'show-any-claim-archived',
                    'history-list-create-claim',
                    'update-active-pilot',
                    'unfounded-claim-awaiting-assignment',
                    'search-claim-any-reference',
                    'attach-files-to-claim',
                    'revive-staff',
                    'pilot-list-any-notification-proof',
                    'list-reporting-titles-configs','update-reporting-titles-configs','edit-reporting-titles-configs',
                ],
                "supervisor-holding" => [],
                "collector-holding" => [
                    'store-claim-against-any-institution',
                    'list-satisfaction-measured-my-claim', 'update-satisfaction-measured-my-claim',
                    'show-dashboard-data-my-activity',
                    'list-claim-incomplete-against-any-institution', 'show-claim-incomplete-against-any-institution', 'update-claim-incomplete-against-any-institution',
                    'history-list-create-claim',
                    'search-claim-any-reference',
                    'attach-files-to-claim',
                    'revive-staff',
                ],
                "staff" => [
                    'show-dashboard-data-my-unit', 'show-dashboard-data-my-activity',
                    'list-my-discussions', 'store-discussion', 'destroy-discussion', 'list-discussion-contributors', 'add-discussion-contributor', 'remove-discussion-contributor', 'contribute-discussion',
                    'list-claim-awaiting-treatment', 'show-claim-awaiting-treatment', 'rejected-claim-awaiting-treatment', 'self-assignment-claim-awaiting-treatment', 'assignment-claim-awaiting-treatment', 'list-claim-assignment-to-staff', 'show-claim-assignment-to-staff',
                    'history-list-treat-claim',
                    'search-claim-any-reference',
                    'attach-files-to-claim'

                ]
            ];

            foreach ($holdingRoles as $roleName => $permissions) {

                $institutionTypes = $this->addInstitutionTypeToRole($roleName, 'holding');

                $role = Role::updateOrCreate(
                    ['name' => $roleName, 'guard_name' => 'api'],
                    ['institution_types' => $institutionTypes]
                );

                if (empty($permissions)) {
                    $role->syncPermissions($permissions);
                    $role->forceDelete();
                } else {
                    // sync permissions
                    foreach ($permissions as $permissionName) {
                        if (Permission::where('name', $permissionName)->where('guard_name', 'api')->doesntExist()) {
                            Permission::create(['name' => $permissionName, 'guard_name' => 'api']);
                        }
                    }

                    $role->syncPermissions($permissions);
                    $role->update(['is_editable' => 0]);
                }

            }

            Permission::doesntHave('roles')->delete();
        }
    }
}
