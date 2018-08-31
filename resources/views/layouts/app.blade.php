<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chilli') . (isset($app_title) ? ' | ' . $app_title : '') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="mihv-100 flex flex-column">
    @include('partials.app.layout.svg')
    @include('partials.app.layout.header')

    <main class="flex-1">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @include('partials.app.layout.footer')
</div>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
