<?php


namespace Satis\CountriesPackage\Facades;


use Illuminate\Support\Facades\Facade;

class State extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "state";
    }
}