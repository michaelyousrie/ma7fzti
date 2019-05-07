@extends('layouts.base')

@section('content')
    <Navbar :user="{{$user}}" />
@endsection
