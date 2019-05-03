@extends('layouts.base')

@section('content')

    <h1 class="text-center">Welcome to my Application <i class="fa fa-hand-peace-o"></i></h1>

    <hr>

    <h3><i class="fa fa-list"></i> Let's build something amazing!</h3>
    
    <br>

    @include("components.input", [
        "name"  => 'name',
        "class" => "text-error"
    ])

    @include("components.textarea", [
        "value"  => 'Horray',
    ])

    @include("components.select", [
        "label" => "Yay",
        "id"    => "yay",
        "options"   => [
            ["value" => "yay", "label" => "Yay"],
            ["value" => "yay2", "label" => "Yay 2"]
        ]
    ])

    @include("components.submit", [
        "label"  => 'Horray',
    ])

    @include("components.button", [
        "label"  => 'Horray',
    ])

@endsection
