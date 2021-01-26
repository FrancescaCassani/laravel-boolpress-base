@extends('layouts.main')

@section('content')
    <div class="container mb-4">
        <h1>BLOG ARCHIVE</h1>

        @forelse ($posts as $post)
            <article class="mb-5">

                {{-- Sessione post cancellazione --}}
                @if (session('post-deleted'))
                    <div class="alert alert-success">
                        Post {{$post->title}} has been deleted successfully
                    </div>
                @endif

                <h2>{{$post->title}}</h2>
                <h5>{{$post->created_at->format('d/m/Y')}}</h5>
                <p>{{$post->body}}</p>
                <a href="{{route('posts.show', $post->slug)}}">Read more</a>
            </article>
        @empty
            <p>No story here. You can write a new one by <a href="{{route('posts.create')}}">clicking here</a></p>
        @endforelse

        {{-- Imposto lo slider delle pagine --}}
        {{$posts->links()}}
    </div>
@endsection
