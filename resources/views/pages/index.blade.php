@extends('layouts.apps')

@section('content')
<div class="jumbotron text-center">
    <h1> Welcome to FiLo!<h1>
        <p>Find-the-Lost</p>
        @if(!Auth::user())
            <p><a class="btn btn-primary btn-lg" href="{{ route('register') }}" role="button">Login</a> <a class="btn btn-success btn-lg"
                    href="{{ route('login') }}" role="button">Register</a></p>
        @endif
</div>
@endsection