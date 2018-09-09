@extends('layouts.app', ['app_title' => 'Профиль'])

@section('content')

    <section class="profile">
        <h1 class="h3">Добрый день, {{ $user->name }}!</h1>
    </section>

@endsection
