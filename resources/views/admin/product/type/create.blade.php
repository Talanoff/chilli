@extends('layouts.admin', ['app_title' => 'Новый тип'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Новый тип
        </h1>

        <form action="{{ route('admin.product.type.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="title">Название типа</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="mt-5">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
