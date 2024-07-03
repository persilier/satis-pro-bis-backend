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

class StateController extends Controller
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
     * @return bool|Response|Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $states = $this->service->getAllStates(true);
        $countries = $this->countryService->getAllAfricaCountries();
        return view("countriespackage::states.index",compact("states","countries"));

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return bool|Response|Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $state = $this->service->getStateById($id);
        return view("countriespackage::states.edit",compact("state"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            "name"=>['string','required']
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator);
        }

        $this->service->updateState($id,$request->only("name"));

        return redirect(route("states.index"))->with(["success"=>"Modification effectuée avec succès !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


