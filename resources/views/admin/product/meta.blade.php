@extends('layouts.admin', ['page_title' => 'Meta информация'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Meta информация
        </h1>

        <form action="{{ route('admin.product.meta.store') }}" method="post">
            @csrf
            @include('partials.admin.meta.meta', ['hide_title' => true])

            <button class="btn btn-primary mt-4">Сохранить</button>
        </form>
    </section>

@endsection
