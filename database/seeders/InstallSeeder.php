<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallChannelSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallComponentSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallInstitutionTypeSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallInstitutionSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallMetadataSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\PurifyRolesPermissionsHoldingSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\PurifyRolesPermissionsFilialSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\PurifyRolesPermissionsMembreSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\PurifyRolesPermissionsObservatorySeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\PurifyRolesPermissionsIndependantSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\PermissionsInstitutionTypesSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallRequirementSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallSeverityLevelSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\InstallAdministratorSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\ReportingTitlesSeeder::class);
        $this->call(\Satis2020\ServicePackage\Database\Seeders\AuthConfigSeeder::class);


    }
}
