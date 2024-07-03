<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Satis2020\ServicePackage\Models\Metadata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurePreventiveRequireStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //Metadata::truncate();
        Metadata::flushEventListeners();

        Metadata::create([
            'id' => (string)Str::uuid(),
            'name' => 'measure-preventive',
            'data' => json_encode(false)
        ]);
    }
}
