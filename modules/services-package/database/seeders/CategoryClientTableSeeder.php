<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Satis2020\ServicePackage\Models\CategoryClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        CategoryClient::truncate();
        CategoryClient::flushEventListeners();
        \Satis2020\ServicePackage\Models\CategoryClient::factory()->count(5)->create();
    }
}
