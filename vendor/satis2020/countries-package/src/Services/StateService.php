<?php


namespace Satis\CountriesPackage\Services;

use Illuminate\Http\Request;
use Satis\CountriesPackage\Repositories\StateRepository;

class StateService
{

    private $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function getAllStates($paginate=false)
    {
        return $this->stateRepository->getAllStates($paginate);
    }

    public function getStateWithCities ($id)
    {
        return $this->stateRepository->getStateWithCities($id);
    }

    public function getStateById ($id)
    {
        return $this->stateRepository->getStateById($id);
    }

    public function getStateByIds ($ids)
    {
        return $this->stateRepository->getStateByIds($ids);
    }

    public function updateState($stateId,$data)
    {
        return $this->stateRepository->updateState($stateId,$data);
    }

    public function filterAndSearchStates(Request $request)
    {
        return $this->stateRepository->filterAndSearch($request);
    }

}
