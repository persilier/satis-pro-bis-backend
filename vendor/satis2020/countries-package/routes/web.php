<?php

use Illuminate\Support\Facades\Route;
use Satis\CountriesPackage\Http\Controllers\Controller;
use Satis\CountriesPackage\Http\Controllers\Country\CountryController;
use Satis\CountriesPackage\Http\Controllers\State\FilterAndSearchStateController;
use Satis\CountriesPackage\Http\Controllers\State\StateController;

Route::get("/",[Controller::class,"index"])->name(config("countriespackage.prefix").'.home');
Route::resource("countries", CountryController::class);
Route::resource("states", StateController::class);
Route::post("states/filter",[FilterAndSearchStateController::class,"search"])->name("states.filter");