<?php


namespace Satis\CountriesPackage\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Satis\CountriesPackage\Console\Commands\InstallCountriesServiceCommand;
use Satis\CountriesPackage\Repositories\CountryRepository;
use Satis\CountriesPackage\Repositories\StateRepository;
use Satis\CountriesPackage\Services\CountryService;
use Satis\CountriesPackage\Services\StateService;

class CountriesPackageServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerFacades();
    }

    public function boot()
    {
        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'countriespackage');
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'countriespackage');
        $this->publishFiles();
        $this->registerCommands();

    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
            $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('countriespackage.prefix'),
            'middleware' => config('countriespackage.middleware'),
        ];
    }

    protected function publishFiles()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('countriespackage.php'),
            ], 'config');

        }
    }

    protected function registerCommands()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCountriesServiceCommand::class
            ]);

        }
    }

    public function registerFacades()
    {
        $this->app->bind('country', function($app) {
            return new CountryService(app(CountryRepository::class));
        });

        $this->app->bind('state', function($app) {
            return new StateService(app(StateRepository::class));
        });
    }

}