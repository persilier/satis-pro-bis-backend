<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Satis2020\ServicePackage\Models\Claim;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //Claim::flushEventListeners();
        \Satis2020\ServicePackage\Models\Claim::factory()->count(1000)->create();
    }
}
