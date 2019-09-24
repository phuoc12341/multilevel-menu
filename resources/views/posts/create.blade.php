@extends('posts.layout')

@section('content')
    <div class="container">
        {!! Form::open(['route' => ['posts.store']]) !!}
            @component('posts.create-or-edit-form')

            @endcomponent
        {!! Form::close() !!}
    </div>
@endsection
