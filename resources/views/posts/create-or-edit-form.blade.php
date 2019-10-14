
    @include('posts.components.title')

    @include('posts.components.description')

    @include('posts.components.body')

    {!! Form::submit( __('messages.submit'), ['class' => 'btn btn-primary']) !!}
