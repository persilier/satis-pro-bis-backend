<?php


namespace Satis\CountriesPackage\Http\Controllers\Country;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Satis\CountriesPackage\Services\CountryService;

class CountryController extends Controller
{

    /**
     * @var CountryService
     */
    private $service;

    public function __construct(CountryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool|Response|Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $countries = $this->service->getAllAfricaCountries(true);
        return view("countriespackage::countries.index",compact("countries"));
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
        $country = $this->service->getCountryById($id);
        return view("countriespackage::countries.edit",compact("country"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            "name"=>['string','required']
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator);
        }

        $this->service->updateCountry($id,$request->only("name"));

        return redirect(route("countries.index"))->with(["success"=>"Modification effectuée avec succès !"]);
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


