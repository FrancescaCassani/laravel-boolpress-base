@extends('layouts.main')

@section('content')
    <div class="container mb-5">
        <h1>404</h1>

        <p class="mb-5">Your hero is not here</p>

        <a class="btn btn-dark" href="{{route('homepage')}}">Back to home</a>

    </div>
@endsection
