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


             {{-- RELAZIONE FRA MODELLI: ACCEDO ALLA PROPRIETA' DI INFOPOST--}}
            <div class="form-group">
                <label for="post_status">Post Status</label>
                <select name="post_status" id="post_status">
                    <option value="public"
                    {{-- Prendo il valore di default salvato nel DB: accedo alla proprietà di infoPost --}}
                    {{old('post_status' , $post->infoPost->post_status) == 'public' ? 'selected' : ''}}
                    >Public</option>
                    <option value="private"
                    {{old('post_status' , $post->infoPost->post_status) == 'private' ? 'selected' : ''}}
                    >Private</option>
                    <option value="draft"
                    {{old('post_status' , $post->infoPost->post_status) == 'draft' ? 'selected' : ''}}
                    >Draft</option>
                </select>
            </div>

            {{-- RELAZIONE FRA MODELLI: ACCEDO ALLA PROPRIETA' DI INFOPOST --}}
            <div class="form-group">
                <label for="comment_status">Comment Status</label>
                <select name="comment_status" id="comment_status">
                    <option value="open"
                    {{old('comment_status' , $post->infoPost->comment_status) == 'open' ? 'selected' : ''}}
                    >Open</option>
                    <option value="closed"
                    {{old('comment_status' , $post->infoPost->comment_status) == 'closed' ? 'selected' : ''}}
                    >Closed</option>
                    <option value="private"
                    {{old('comment_status' , $post->infoPost->comment_status) == 'private' ? 'selected' : ''}}
                    >Private</option>
                </select>
            </div>


             {{-- TAGS --}}
             <div class="form-group">
                @foreach ($tags as $tag)
                    <div class="form-check">
                        <input class="from-check-input" type="checkbox" name="tags[]" id="tag-{{$tag->id}}" value="{{$tag->id}}"
                        {{-- Cerca corrispondenza con l id precedentemente inserito --}}
                        @if ($post->tags->contains($tag->id)) checked @endif
                        >
                        <label for="tag-{{$tag->id}}"> {{$tag->name}} </label>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <input class="btn btn-dark" type="submit" value="Update post">
            </div>
        </form>
    </div>
@endsection
