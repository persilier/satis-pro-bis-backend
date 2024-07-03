<?php


namespace Satis\CountriesPackage\Http\Controllers\City;


use App\Http\Controllers\ApiController;
use App\Services\CountryService;

class CitiesByCountryController extends ApiController
{

    private $countryService;

    public function __construct(CountryService $countryService)
    {
        parent::__construct();
        $this->countryService = $countryService;
    }

    public function find($id)
    {
        return $this->successResponse($this->countryService->countryWithCities($id));
    }

}
