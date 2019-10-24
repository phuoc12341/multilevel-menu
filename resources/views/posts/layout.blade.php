<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {!! Html::meta(null, null, ['charset' => 'utf-8']) !!}
        {!! Html::meta('viewport', 'width=device-width, initial-scale=1') !!}
        
        <!-- CSRF Token -->
        {!! Html::meta('csrf', csrf_token()) !!}

        {!! Html::tag('title', config('app.name', 'Laravel'))  !!}

        <!-- Scripts -->
        {!! Html::script('js/app.js', ['defer']) !!}
        
        <!-- Fonts -->
        {!! Html::style('//fonts.gstatic.com', ['rel' => 'dns-prefetch']) !!}

        <!-- Styles -->
        {!! Html::style('css/app.css', ['rel' => 'stylesheet']) !!}

        {!! Html::tag('base', '', ['href' => url('/')]) !!}
    </head>
    <body>
        @yield('content')

        {!! Html::script('js/app.js') !!}
        @stack('scripts')
    </body>
</html>
