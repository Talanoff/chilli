<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chilli') . (isset($app_title) ? ' | ' . $app_title : '') }}</title>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:100,300,400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
@include('partials.admin.layout.svg')
@include('partials.admin.alert.error')

<div id="app">
    @includeIf('partials.admin.layout.header')
    @includeIf('partials.admin.layout.aside')

    <main>
        @yield('content')
    </main>
</div>

<script src="{{ asset('js/admin.js') }}" async defer></script>
@stack('scripts')
@routes
</body>
</html>
