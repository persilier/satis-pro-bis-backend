@extends("countriespackage::layout.layout")
@section("content")
    <section>
        <div class="row m-4" style="border-left: 2px solid gray">
            <h1 class="">States</h1>
        </div>

        <div>

            <div class="d-flex justify-content-center">
                <form  action="{{route("states.filter")}}" method="post" class="">
                    @csrf
                    <div class="input-group">
                        @if(isset($request))
                            <select name="country_id"  class="form-control">
                                <option>Tous les pays</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{$request->filled('country_id') && $request->country_id==$country->id? 'selected' :''}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="key" placeholder="Recherche" value="{{$request->filled('key') ? $request->key :''}}" class="form-control">
                        @else
                            <select name="country_id"  class="form-control">
                                <option>Tous les pays</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="key" placeholder="Recherche" class="form-control">
                        @endif
                            <input type="submit" value="Filtrer" aria-label="Last name" class="btn btn-primary">

                            <a class="btn btn-primary" style="margin-left: 2px" href="{{route("states.index")}}">Réinitialiser</a>
                    </div>
                </form>
            </div>

            <br><br>
            @if(session()->has("success"))
                <h4 class="alert alert-success">{{session('success')}}</h4>
            @endif
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Pays</th>
                    <th>ISO2</th>
                </tr>
                </thead>
                <tbody>
                @foreach($states as $state)
                    <tr>
                        <td>{{$state->name}}</td>
                        <td>{{$state->country->name}}</td>
                        <td>{{$state->iso2}}</td>
                        <td><a href="{{route('states.edit',$state->id)}}"><i class="bi bi-pencil"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br><br>
            <div class="row">
                {{$states->links()}}
            </div>
        </div>
    </section>

@endsection