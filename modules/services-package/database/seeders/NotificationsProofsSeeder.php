<?php

namespace Satis2020\ServicePackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Satis2020\ServicePackage\Models\NotificationProof;

class NotificationsProofsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        NotificationProof::flushEventListeners();

        \Satis2020\ServicePackage\Models\NotificationProof::factory()->count(50)->create();
    }
}
