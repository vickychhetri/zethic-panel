@extends('admin.layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="jumbotron">
        <h1 class="display-4">Welcome, {{$logged->name}}</h1>
        <p class="lead">Zethic Technologies Dashboard.</p>
        <hr class="my-4">

    </div>
@endsection
