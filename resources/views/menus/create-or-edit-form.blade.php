
    @include('menus.components.name')

    @include('menus.components.parent')

    @include('menus.components.type-of-menu')

    @include('menus.components.menu-associate')

    {!! Form::submit( __('messages.submit'), ['class' => 'btn btn-primary']) !!}
