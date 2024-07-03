<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Illuminate\Support\Str;
use Satis2020\ServicePackage\Models\PerformanceIndicator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformanceIndicatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        PerformanceIndicator::truncate();
        PerformanceIndicator::flushEventListeners();
        \Satis2020\ServicePackage\Models\PerformanceIndicator::factory()->count(5)->create();
    }
}
