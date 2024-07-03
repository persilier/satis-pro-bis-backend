<?php


namespace Satis\CountriesPackage\Facades;


use Illuminate\Support\Facades\Facade;

class Country extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "country";
    }
}