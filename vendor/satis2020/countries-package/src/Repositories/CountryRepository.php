<?php


namespace Satis\CountriesPackage\Repositories;



use Satis\CountriesPackage\Models\Country;

class CountryRepository
{

    /**
     * @param $selectedFields
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllCountries ()
    {
        return Country::all();
    }

    /**
     * @param bool $paginate
     * @return mixed
     */
    public function getAllAfricaCountries ($paginate=false)
    {
        $countries = Country::query()->where('region', 'Africa');

        return $paginate?$countries->paginate():$countries->get();
    }

    public function getCountryWithStates ($id)
    {
        return Country::with('states')->firstWhere('id', $id);
    }

    public function getCountryWithCities ($id)
    {
        return Country::with('cities')->firstWhere('id', $id);
    }

    public function getCountryByPhoneCode ($phoneCode)
    {
        return Country::with('cities')->firstWhere('phonecode', $phoneCode);
    }

    public function getCountryById ($countryId)
    {
        return Country::query()->firstWhere('id', $countryId);
    }

    public function updateCountry ($countryId,$data)
    {
        return Country::query()
            ->where("id",$countryId)
            ->update($data);
    }

}
