@extends('layouts.main')

@section('content')
    <div class="container mb-5">
        <h1>{{$post->title}}</h1>
        <div>Last update: {{$post->updated_at->diffForHumans()}}</div>

        <div class="actions mb-5">
            <a class="btn btn-primary mt-3" href="{{route('posts.edit', $post->slug)}}">Edit</a>
        </div>

        {{-- Se non è vuoto --}}
        @if (!empty($post->path_img))
            <img src="{{asset('storage/' . $post->path_img)}}" alt="{{$post->title}}">
        @else
            <img src="{{asset('img/no-img.png')}}" alt="{{$post->title}}">
        @endif

        <div class="text mb-6 mt-6">
            {{$post->body}}
        </div>

    </div>
@endsection
