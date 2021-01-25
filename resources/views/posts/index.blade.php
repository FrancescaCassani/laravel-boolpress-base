@extends('layouts.main')

@section('content')
    <div class="container mb-4">
        <h1>BLOG ARCHIVE</h1>

        @forelse ($posts as $post)
            <article class="mb-5">
                <h2>{{$post->title}} {{$post->symbol}}</h2>
                <h5>{{$post->created_at->format('d/m/Y')}}</h5>
                <p>{{$post->body}}</p>
                <a href="{{route('posts.show', $post->slug)}}">Read more</a>
            </article>
        @empty


        @endforelse
    </div>
@endsection
