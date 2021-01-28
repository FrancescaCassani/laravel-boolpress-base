@extends('layouts.main')

@section('content')
    <div class="container mb-5">
        <h1>{{$post->title}}</h1>
        <div>
            <h3>Last update: {{$post->updated_at->diffForHumans()}}</h3>
        </div>

        {{-- @dump($post->infoPost->post_status) --}}
        {{-- Non usare metodo ma variabile. Si richiama lo stesso nome indicato nella funzione di relazione fra le tabelle--}}
        <div class="">Post status: {{$post->infoPost->post_status}}</div>

        <div class="actions mb-5 mt-3">
            <a class="btn btn-dark" href="{{route('posts.edit', $post->slug)}}">Edit</a>

            {{-- Imposto la cancellazione del post singolo. Mi basta il semplice ID. Imposto il @method con 'DELETE'--}}
            <form class="d-inline" action="{{route('posts.destroy', $post->id)}}" method="POST">
                @csrf
                @method('DELETE')

                <input class="btn btn-danger" type="submit" value="delete">
            </form>
        </div>

        {{-- TAGS --}}
        <section class="tags">
            <h5>Tags</h5>
            @forelse ($post->tags as $tag)
                <span class="badge badge-primary">{{$tag->name}}</span>
            @empty
                <p>No tags selected.</p>
            @endforelse
        </section>



        {{-- Se non è vuoto --}}
        @if (!empty($post->path_img))
            <img src="{{asset('storage/' . $post->path_img)}}" alt="{{$post->title}}">
        @else
            <img src="{{asset('img/no-img.png')}}" alt="{{$post->title}}">
        @endif

        <div class="text mb-6 mt-6">
            {{$post->body}}
        </div>

        {{-- @dump($post->comments) uso per vedere array a video --}}
        <h3>Comments</h3>
        <ul class="comments">
            @foreach ($post->comments as $comment)
                <li class="mb-4">
                    <div class="date">{{$comment->created_at->diffForHumans()}}</div>
                    <p class="text">{{$comment->text}}</p>
                    <h6>{{$comment->author}}</h6>
                </li>
            @endforeach
        </ul>

    </div>
@endsection
