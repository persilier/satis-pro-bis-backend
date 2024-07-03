<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Satis2020\ServicePackage\Database\Seeders\ClaimSeeder;
use Satis2020\ServicePackage\Database\Seeders\ClaimValidatedSeeder;

class GenerateClaimsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(ClaimSeeder::class);
        $this->call(ClaimValidatedSeeder::class);
    }
}
