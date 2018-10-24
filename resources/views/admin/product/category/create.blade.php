@extends('layouts.admin', ['app_title' => 'Новая категория'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Новая категория
        </h1>

        <form action="{{ route('admin.product.category.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="title">Название категории</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="mt-5">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
