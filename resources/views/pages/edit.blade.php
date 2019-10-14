@extends('pages.layout')

@section('content')
    <div class="container">
        {!! Form::model($page, ['route' => ['pages.update', 'page' => $page->slug], 'method' => 'patch' ]) !!}

            @component('pages.create-or-edit-form')

            @endcomponent
        {!! Form::close() !!}

    </div>
@endsection
