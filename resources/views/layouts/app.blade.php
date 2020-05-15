<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ str_replace('_', '-', app()->getLocale())==='ar'?'rtl':'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
        <meta name="user" content="{{ Auth::user() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-token" content="{{ auth()->user() }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/tailwind.css">
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@1.x/dist/vuetify.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <style>
            body{
                font-family:Roboto;
                background:#1a202c;
            }
            .mb-4{
                margin-bottom:10px !important;
            }
            .righteous-font{
                font-family: 'Righteous';
            }
        </style>

        <title>@yield('title')</title>
        @yield('extra-head')

    </head>
    <body>
        <div id="app">
            @yield('vue-components')
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('extra-js')
</html>