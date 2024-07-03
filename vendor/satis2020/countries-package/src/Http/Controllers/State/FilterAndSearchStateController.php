<?php


namespace Satis\CountriesPackage\Http\Controllers\State;


use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Satis\CountriesPackage\Http\Controllers\Controller;
use Satis\CountriesPackage\Services\CountryService;
use Satis\CountriesPackage\Services\StateService;

class FilterAndSearchStateController extends Controller
{

    /**
     * @var StateService
     */
    private $service;
    /**
     * @var CountryService
     */
    private $countryService;

    public function __construct(StateService $service,CountryService $countryService)
    {
        $this->service = $service;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|Response|Application|Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        $states = $this->service->filterAndSearchStates($request);
        $countries = $this->countryService->getAllAfricaCountries();
        return view("countriespackage::states.index",compact("states","request","countries"));
    }



}


