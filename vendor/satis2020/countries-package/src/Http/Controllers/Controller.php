<?php


namespace Satis\CountriesPackage\Http\Controllers;


class Controller extends \Illuminate\Routing\Controller
{

    public function index()
    {
        return view("countriespackage::home");
    }
}