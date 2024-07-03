<?php


namespace Satis\CountriesPackage\Traits;


use Satis\CountriesPackage\Models\Country;
use Satis\CountriesPackage\Models\State;

trait HasCountryTrait
{

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}