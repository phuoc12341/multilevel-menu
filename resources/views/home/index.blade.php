@extends('home.layout')

@section('navigation')
    <nav id="navigation">
        @if ( $listMenu->isNotEmpty() )
            <ul id="main-menu">
                @foreach ($listMenu as $menu)
                    @include('home.sub-menu', $menu)
                @endforeach
            </ul>
        @endif
    </nav>
@endsection
