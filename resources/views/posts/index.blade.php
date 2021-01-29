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

                <div class="mb-2">
                    <h2>{{$post->title}}</h2>
                    <h5>{{$post->created_at->format('d/m/Y')}}</h5>
                    @if (!empty($post->path_img))
                        <img width="300" src="{{asset('storage/' . $post->path_img)}}" alt="{{$post->title}}">
                    @else
                        <img src="{{asset('img/no-img.png')}}" alt="{{$post->title}}">
                    @endif
                    <div>
                        <a href="{{route('posts.show', $post->slug)}}">Scopri di più</a>
                    </div>
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
            </article>
        @empty
            <p>No story here. You can write a new one by <a href="{{route('posts.create')}}">clicking here</a></p>
        @endforelse

        {{-- Imposto lo slider delle pagine --}}
        {{$posts->links()}}
    </div>
@endsection
