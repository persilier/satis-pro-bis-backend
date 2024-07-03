<?php


namespace Satis\CountriesPackage\Models;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $guarded = [];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}