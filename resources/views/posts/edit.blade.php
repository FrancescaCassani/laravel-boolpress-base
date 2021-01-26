@extends('layouts.main')

@section('content')
    <div class="container mb-5">
        <h1>Edit: {{$post->title}}</h1>

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

        {{-- Encoding necessario per passaggio immagini oltre che testo e punto la rotta posts.update per immagazzinare le nuove informazioni. Modifico il method in 'PATCH'. NB: posso usare semplicemente l ID non avendo nuove view--}}
        <form action="{{route('posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
            {{-- Crosssidereference --}}
            @csrf
            @method('PATCH')

            {{-- Per editare un post e far riapparire il testo --}}
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" name="title" id="title" value="{{old('title', $post->title)}}">
            </div>

            <div class="form-group">
                <label for="body">History</label>
                <textarea class="form-control" type="text" name="body" id="body">{{old('body', $post->body)}}</textarea>
            </div>

            {{-- Controllo che l'immagine sia effettiavemnte stata inserita --}}
            <div class="form-group">
                <label for="path_img">Post image</label>
                @isset($post->path_img)
                    <div class="wrap-image">
                    <img width="200" src="{{asset('storage/' . $post->path_img)}}" alt="{{$post->title}}">
                    </div>
                    <h6>Change:</h6>
                @endisset
                <input class="form-control"  type="file" name="path_img" id="path_img" accept="image/*">
            </div>

            <div class="form-group">
                <input class="btn btn-dark" type="submit" value="Update post">
            </div>
        </form>
    </div>
@endsection
