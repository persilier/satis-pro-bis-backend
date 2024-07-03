<?php


namespace Satis\CountriesPackage\Models;


use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}