@extends('pages.layout')

@section('content')
    <div class="container">
        {!! Form::open(['route' => ['pages.store']]) !!}
            @component('pages.create-or-edit-form')

            @endcomponent
        {!! Form::close() !!}
    </div>
@endsection
