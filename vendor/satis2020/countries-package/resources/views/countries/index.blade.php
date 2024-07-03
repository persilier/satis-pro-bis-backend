@extends("countriespackage::layout.layout")
@section("content")
    <section>
        <div class="row m-4" style="border-left: 2px solid gray">
            <h1 class="">Countries</h1>
        </div>

        <div>
            @if(session()->has("success"))
                <h4 class="alert alert-success">{{session('success')}}</h4>
                @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>ISO3</th>
                        <th>Numéric code</th>
                        <th>Phone Code</th>
                        <th>Capital</th>
                        <th>Devise</th>
                        <th>Région</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $country)
                        <tr>
                            <td>{{$country->name}}</td>
                            <td>{{$country->iso3}}</td>
                            <td>{{$country->numeric_code}}</td>
                            <td>{{$country->phonecode}}</td>
                            <td>{{$country->capital}}</td>
                            <td>{{$country->currency}}</td>
                            <td>{{$country->region}}</td>
                            <td><a href="{{route('countries.edit',$country->id)}}"><i class="bi bi-pencil"></i></a></td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
            <br><br>
            <div class="row">
                {{$countries->links()}}
            </div>
        </div>
    </section>


@endsection