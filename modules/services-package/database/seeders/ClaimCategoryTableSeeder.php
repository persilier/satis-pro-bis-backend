<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Satis2020\ServicePackage\Models\ClaimCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaimCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ClaimCategory::truncate();
        ClaimCategory::flushEventListeners();
        \Satis2020\ServicePackage\Models\ClaimCategory::factory()->count(5)->create();
    }
}
