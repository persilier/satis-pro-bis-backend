<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Satis2020\ServicePackage\Models\Identite;
use Satis2020\ServicePackage\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Identite::truncate();
        Identite::flushEventListeners();
        \Satis2020\ServicePackage\Models\Identite::factory()->count(15)->create();
    }
}
