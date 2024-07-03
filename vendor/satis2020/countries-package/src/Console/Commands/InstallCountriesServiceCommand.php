<?php

namespace Satis\CountriesPackage\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Satis2020\ServicePackage\Models\Institution;
use Satis2020\ServicePackage\Models\InstitutionMessageApi;
use Satis2020\ServicePackage\Services\SendSMService;

class InstallCountriesServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countries-service:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importation des pays, zones et villes de tout les pays';

    protected $db;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE')
            ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info("Installation du service en cours...");

        try {

            $this->importCountries();
            $this->importStates();
            $this->info("Installation du service terminée !");

        }catch (\Exception $exception){
            Log::debug($exception);
            $this->error($exception->getMessage());
        }

        return 1;
    }

    private function importCountries()
    {

        $sql = __DIR__.'/sqls/countries.sql';
        $this->importSql($sql);

        $this->info("Importation des pays terminée !");
    }

    private function importStates()
    {
        $sql = __DIR__.'/sqls/states.sql';
        $this->importSql($sql);

        $this->info("Importation des zones terminée !");
    }

    private function importSql($sql)
    {
        DB::unprepared(file_get_contents($sql));
    }
}
