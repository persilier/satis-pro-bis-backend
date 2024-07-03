<?php


namespace Satis\CountriesPackage\Http\Controllers\City;


use App\Http\Controllers\ApiController;
use Satis\CountriesPackage\Services\StateService;

class CitiesByStateController extends ApiController
{

    private $stateService;

    public function __construct(StateService $stateService)
    {
        parent::__construct();
        $this->stateService = $stateService;
    }

    public function find($id)
    {
        return $this->successResponse($this->stateService->stateWithCities($id));
    }

}
