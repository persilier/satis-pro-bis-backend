<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Satis2020\ServicePackage\Models\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PurifyRolesPermissionsIndependantSeeder extends Seeder
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
        if ($nature === 'PRO') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            $independantRoles = [
                "admin-pro" => [
                    'list-category-client', 'store-category-client', 'update-category-client', 'destroy-category-client', 'show-category-client',
                    'list-channel', 'store-channel', 'update-channel', 'destroy-channel', 'show-channel',
                    'list-claim-category', 'store-claim-category', 'update-claim-category', 'destroy-claim-category', 'show-claim-category',
                    'list-claim-object', 'store-claim-object', 'update-claim-object', 'destroy-claim-object', 'show-claim-object',
                    'update-claim-object-requirement',
                    'list-client-from-my-institution', 'store-client-from-my-institution', 'update-client-from-my-institution', 'destroy-client-from-my-institution', 'show-client-from-my-institution',
                    'show-mail-parameters', 'update-mail-parameters',
                    'show-sms-parameters', 'update-sms-parameters',
                    'list-currency', 'store-currency', 'update-currency', 'destroy-currency', 'show-currency',
                    'list-faq-category', 'store-faq-category', 'update-faq-category', 'destroy-faq-category', 'show-faq-category',
                    'list-message-apis', 'store-message-apis', 'update-message-apis', 'destroy-message-apis', 'update-my-institution-message-api',
                    'update-my-institution',
                    'list-position', 'store-position', 'update-position', 'destroy-position', 'show-position',
                    'list-unit-type', 'store-unit-type', 'update-unit-type', 'destroy-unit-type', 'show-unit-type',
                    'list-my-unit', 'store-my-unit', 'update-my-unit', 'destroy-my-unit', 'show-my-unit',
                    'list-category-client-from-my-institution', 'store-category-client-from-my-institution', 'update-category-client-from-my-institution', 'destroy-category-client-from-my-institution', 'show-category-client-from-my-institution',
                    'update-notifications',
                    'list-performance-indicator', 'store-performance-indicator', 'update-performance-indicator', 'destroy-performance-indicator', 'show-performance-indicator', 'edit-performance-indicator',
                    'update-processing-circuit-my-institution',
                    'list-severity-level', 'update-severity-level', 'show-severity-level',
                    'list-staff-from-my-unit', 'store-staff-from-my-unit', 'update-staff-from-my-unit', 'destroy-staff-from-my-unit', 'show-staff-from-my-unit',
                    'show-dashboard-data-my-institution',
                    'list-account-type', 'show-account-type', 'update-account-type', 'store-account-type', 'destroy-account-type',
                    'list-user-my-institution', 'show-user-my-institution', 'store-user-my-institution',
                    'list-delai-qualification-parameters', 'show-delai-qualification-parameters', 'store-delai-qualification-parameters', 'destroy-delai-qualification-parameters',
                    'list-delai-treatment-parameters', 'show-delai-treatment-parameters', 'store-delai-treatment-parameters', 'destroy-delai-treatment-parameters',
                    'update-components-parameters',
                    'list-my-institution-type-role', 'show-my-institution-type-role', 'store-my-institution-type-role', 'update-my-institution-type-role', 'destroy-my-institution-type-role',
                    'update-active-pilot',
                    'update-recurrence-alert-settings',
                    'update-reject-unit-transfer-parameters',
                    'update-min-fusion-percent-parameters',
                    'update-relance-parameters',
                    'update-measure-preventive-parameters',
                    'show-faq', 'store-faq', 'update-faq', 'delete-faq',
                    'search-claim-my-reference',
                    "my-email-claim-configuration",
                    'list-notification-proof',
                    'export-notification-proof',
                    'list-reporting-titles-configs', 'update-reporting-titles-configs', 'edit-reporting-titles-configs',
                    'bci-monthly-reports', 'bci-annual-reports',
                    'list-webhooks-config','store-webhooks-config','update-webhooks-config','delete-webhooks-config',
                    'logout-user-my-institution'
                ],
                "pilot" => [
                    'list-claim-awaiting-assignment', 'show-claim-awaiting-assignment', 'merge-claim-awaiting-assignment',
                    'store-claim-against-my-institution',
                    'list-claim-awaiting-validation-my-institution', 'show-claim-awaiting-validation-my-institution', 'validate-treatment-my-institution',
                    'list-my-claim-archived', 'show-my-claim-archived',
                    'list-satisfaction-measured-my-claim', 'update-satisfaction-measured-my-claim',
                    'list-my-discussions', 'list-discussion-contributors', 'contribute-discussion',
                    'list-monitoring-claim-my-institution',
                    'list-reporting-claim-my-institution',
                    'transfer-claim-to-circuit-unit',
                    'list-claim-incomplete-against-my-institution', 'show-claim-incomplete-against-my-institution', 'update-claim-incomplete-against-my-institution',
                    'show-dashboard-data-my-institution',
                    'history-list-create-claim',
                    'update-active-pilot',
                    'unfounded-claim-awaiting-assignment',
                    'search-claim-my-reference',
                    'attach-files-to-claim',
                    'revive-staff',
                    'pilot-list-notification-proof',
                    'pilot-export-notification-proof',
                    'list-reporting-titles-configs', 'update-reporting-titles-configs', 'edit-reporting-titles-configs',
                    'bci-monthly-reports', 'bci-annual-reports',
                    'list-webhooks-config','store-webhooks-config','update-webhooks-config','delete-webhooks-config',

                ],
                "supervisor-pro" => [],
                "collector-filial-pro" => [
                    'store-claim-against-my-institution',
                    'list-satisfaction-measured-my-claim', 'update-satisfaction-measured-my-claim',
                    'list-claim-incomplete-against-my-institution', 'show-claim-incomplete-against-my-institution', 'update-claim-incomplete-against-my-institution',
                    'show-dashboard-data-my-activity',
                    'history-list-create-claim',
                    'search-claim-my-reference',
                    'attach-files-to-claim',
                    'revive-staff',
                ],
                "staff" => [
                    'list-claim-awaiting-treatment', 'show-claim-awaiting-treatment', 'rejected-claim-awaiting-treatment', 'self-assignment-claim-awaiting-treatment', 'assignment-claim-awaiting-treatment', 'list-claim-assignment-to-staff', 'show-claim-assignment-to-staff',
                    'list-my-discussions', 'store-discussion', 'destroy-discussion', 'list-discussion-contributors', 'add-discussion-contributor', 'remove-discussion-contributor', 'contribute-discussion',
                    'show-dashboard-data-my-unit',
                    'show-dashboard-data-my-activity',
                    'history-list-treat-claim',
                    'search-claim-my-reference',
                    'attach-files-to-claim',
                    'show-my-staff-monitoring',
                    'list-unit-revivals','list-staff-revivals',
                    'revive-staff',
                ]
            ];

            foreach ($independantRoles as $roleName => $permissions) {

                $institutionTypes = $this->addInstitutionTypeToRole($roleName, 'independant');

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

            Permission::where('guard_name', 'api')->update(['module_id' => null]);

            $modules = [
                "Collecte" => "collector-filial-pro",
                "Traitement" => "staff",
                "Pilotage du processus" => "pilot",
                "Administration" => "admin-pro"
            ];

            $permissionsAssociatedToModules = collect([]);

            foreach ($modules as $moduleName => $roleName) {
                // CreateOrUpdate $module
                $module = Module::updateOrCreate(
                    ['name->' . app()->getLocale() => $moduleName],
                    ["name" => $moduleName, "description" => $moduleName]
                );

                $modulePermissions = $independantRoles[$roleName];

                foreach ($modulePermissions as $permissionName) {
                    // verify if permission already have module
                    if ($permissionsAssociatedToModules->search($permissionName) === false) {
                        // Associate permission to module
                        Permission::where('guard_name', 'api')->where('name', $permissionName)->update(['module_id' => $module->id]);
                        // Add permission to permissionsAssociatedToModules
                        $permissionsAssociatedToModules->push($permissionName);
                    }
                }
            }
        }
    }
}
