@extends('movie::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('movie.name') !!}</p>
@endsection
