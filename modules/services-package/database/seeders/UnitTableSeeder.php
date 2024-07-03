<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Satis2020\ServicePackage\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Unit::truncate();
        Unit::flushEventListeners();
        \Satis2020\ServicePackage\Models\Unit::factory()->count(5)->create();
    }
}
