<?php


namespace Satis\CountriesPackage\Services;

use Illuminate\Database\Eloquent\Collection;
use Satis\CountriesPackage\Models\Country;
use Satis\CountriesPackage\Repositories\CountryRepository;

class CountryService
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return Country[]|Collection
     */
    public function getAllCountries ()
    {

        $countries = $this->countryRepository->getAllCountries();

        foreach ($countries as $country) {
            if (isset($country->translations)) {
                $country->translations = json_decode($country->translations, TRUE);
            }
            if (isset($country->timezones)) {
                $country->timezones = json_decode($country->timezones, TRUE);
            }
        }

        return $countries;
    }

    /**
     * @param bool $paginate
     * @return Country[]|Collection
     */
    public function getAllAfricaCountries ($paginate=false)
    {

        $countries = $this->countryRepository->getAllAfricaCountries($paginate);

        foreach ($countries as $country) {
            if (isset($country->translations)) {
                $country->translations = json_decode($country->translations, TRUE);
            }
            if (isset($country->timezones)) {
                $country->timezones = json_decode($country->timezones, TRUE);
            }
        }

        return $countries;
    }

    public function getCountryWithStates ($id)
    {
        $country = $this->countryRepository->getCountryWithStates($id);

        if (isset($country->translations)) {
            $country->translations = json_decode($country->translations, TRUE);
        }

        if (isset($country->timezones)) {
            $country->timezones = json_decode($country->timezones, TRUE);
        }

        return $country;
    }

    public function getCountryWithCities ($id)
    {
        $country = $this->countryRepository->getCountryWithCities($id);

        if (isset($country->translations)) {
            $country->translations = json_decode($country->translations, TRUE);
        }

        if (isset($country->timezones)) {
            $country->timezones = json_decode($country->timezones, TRUE);
        }

        return $country;
    }

    public function getCountryByPhoneCode ($phoneCode)
    {
        $country = $this->countryRepository->getCountryByPhoneCode($phoneCode);

        if (isset($country->translations)) {
            $country->translations = json_decode($country->translations, TRUE);
        }

        if (isset($country->timezones)) {
            $country->timezones = json_decode($country->timezones, TRUE);
        }

        return $country;
    }
    public function getCountryById ($countryId)
    {
        $country = $this->countryRepository->getCountryById($countryId);

        if (isset($country->translations)) {
            $country->translations = json_decode($country->translations, TRUE);
        }

        if (isset($country->timezones)) {
            $country->timezones = json_decode($country->timezones, TRUE);
        }

        return $country;
    }

    public function updateCountry($countryId,$data)
    {
        return $this->countryRepository->updateCountry($countryId,$data);
    }

}
