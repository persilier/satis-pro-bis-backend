<?php


namespace Satis\CountriesPackage\Traits;


use Satis\CountriesPackage\Models\State;

trait HasStateTrait
{

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}