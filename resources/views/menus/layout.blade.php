<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {!! Html::meta(null, null, ['charset' => 'utf-8']) !!}
        {!! Html::meta('viewport', 'width=device-width, initial-scale=1') !!}
        
        <!-- CSRF Token -->
        {!! Html::meta('csrf', csrf_token()) !!}

        {!! Html::tag('title', config('app.name', 'Laravel'))  !!}

        <!-- Scripts -->
        {!! Html::script('js/app.css', ['defer']) !!}

        <!-- Fonts -->
        {!! Html::style('//fonts.gstatic.com', ['rel' => 'dns-prefetch']) !!}

        <!-- Styles -->
        {!! Html::style('css/app.css', ['rel' => 'stylesheet']) !!}

        {!! Html::tag('base', '', ['href' => url('/')]) !!}
        @yield('style')
    </head>
    <body>
        @yield('content')

        @stack('script')
    </body>
</html>
