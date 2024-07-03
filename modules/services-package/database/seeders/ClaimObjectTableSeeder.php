<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Satis2020\ServicePackage\Models\ClaimObject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimObjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ClaimObject::truncate();
        ClaimObject::flushEventListeners();
        \Satis2020\ServicePackage\Models\ClaimObject::factory()->count(10)->create();
    }
}
