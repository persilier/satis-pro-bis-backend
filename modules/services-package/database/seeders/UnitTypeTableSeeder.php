<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Satis2020\ServicePackage\Models\UnitType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        UnitType::truncate();
        UnitType::flushEventListeners();
        \Satis2020\ServicePackage\Models\UnitType::factory()->count(5)->create();
    }
}
