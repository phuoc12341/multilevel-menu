@extends('posts.layout')

@section('content')
    <div class="container">
        {!! Form::model($post, ['route' => ['posts.update', 'post' => $post->slug], 'method' => 'patch' ]) !!}

            @component('posts.create-or-edit-form')

            @endcomponent
        {!! Form::close() !!}

    </div>
@endsection
