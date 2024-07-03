<?php


namespace Satis\CountriesPackage\Repositories;



use Illuminate\Http\Request;
use Satis\CountriesPackage\Models\State;

class StateRepository
{

    public function getAllStates ($paginate=false)
    {
        $states =  State::query()->with('country');

        return $paginate?$states->paginate():$states->get();
    }
    public function getStateById ($id)
    {
        return State::with('country')->findOrFail($id);
    }

    public function getStateByIds ($ids)
    {
        return State::with('country')->whereIn('id', $ids)->get();
    }

    public function getStateWithCities ($id)
    {
        return State::with('cities')->firstWhere('id', $id);
    }

    public function updateState($stateId,$data)
    {
        return State::query()->where('id',$stateId)->update($data);
    }

    public function filterAndSearch(Request $request)
    {
        $states = State::query();

        if ($request->filled("country_id")){
            $states->where('country_id',$request->country_id);
        }

        if ($request->filled("key")){
            $key = $request->key;
            $states->where('name',"LIKE","%$key%")
                ->orWhere('iso2');
        }

        return $states->paginate();
    }
}
