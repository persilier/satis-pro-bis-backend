@extends("countriespackage::layout.layout")
@section("content")
    <section>
        <div >
            <h1>{{$state->name}}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="post" class="col-8 justify-content-center" action="{{route("states.update",$state->id)}}">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <input type="text" name="name" value="{{$state->name}}" required class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Modifier <i class="bi bi-pencil"></i></button>
                </div>
            </form>
        </div>

    </section>


@endsection