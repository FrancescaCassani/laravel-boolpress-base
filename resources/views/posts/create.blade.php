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
            {{-- Crossidereference --}}
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

            {{-- Visibilità POST-STATUS del post. Lavoro sulla tenuta della selected --->poi vado nel controller dello STORE--}}
            <div class="form-group">
                <label for="post_status">Post Status</label>
                <select name="post_status" id="post_status">
                    <option value="public" {{old('post_status') == 'public' ? 'selected' : ''}}>Public</option>
                    <option value="private" {{old('post_status') == 'private' ? 'selected' : ''}}>Private</option>
                    <option value="draft" {{old('post_status') == 'draft' ? 'selected' : ''}}>Draft</option>
                </select>
            </div>

            {{-- Visibilità COMMENT-STATUS del post. Lavoro sulla tenuta della selected--}}
            <div class="form-group">
                <label for="comment_status">Comment Status</label>
                <select name="comment_status" id="comment_status">
                    <option value="open" {{old('comment_status') == 'open' ? 'selected' : ''}}>Open</option>
                    <option value="closed" {{old('comment_status') == 'closed' ? 'selected' : ''}}>Closed</option>
                    <option value="private" {{old('comment_status') == 'private' ? 'selected' : ''}}>Private</option>
                </select>
            </div>


            {{-- Visibilità TAGS del post. NB uso [] per creare un array di ID di TAG, per verificare tutti i tag selezionati --}}
            <div class="form-group">
                @foreach ($tags as $tag)
                    <div class="form-check">
                        <input class="from-check-input" type="checkbox" name="tags[]" id="tag-{{$tag->id}}" value="{{$tag->id}}">
                        <label for="tag-{{$tag->id}}"> {{$tag->name}} </label>
                    </div>
                @endforeach

            </div>


            <div class="form-group">
                <input class="btn btn-dark" type="submit" value="Create post">
            </div>
        </form>

    </div>
@endsection
