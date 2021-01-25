@extends('layouts.main')

@section('content')
    <div class="container mb-5">
        <h1>Create a new post here</h1>

        {{-- Controllo errori di inserimento informazioni da parte dell'utente --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{$error}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Encoding necessario per passaggio immagini oltre che testo e punto la rotta posts.store per immagazzinare le informazioni--}}
        <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
            {{-- Crosssidereference --}}
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" name="title" id="title" value="{{old('title')}}">
            </div>

            <div class="form-group">
                <label for="body">History</label>
                <textarea class="form-control" type="text" name="body" id="body">{{old('body')}}</textarea>
            </div>

            {{-- Controllo con accept="image/*" che il file sia una image --}}
            <div class="form-group">
                <label for="path_img">Post image</label>
                <input class="form-control"  type="file" name="path_img" id="path_img" accept="image/*">
            </div>


            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Create post">
            </div>
        </form>

    </div>
@endsection
