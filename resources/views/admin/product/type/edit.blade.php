@extends('layouts.admin', ['app_title' => $type->title])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            {{ $type->title }}
        </h1>

        <form action="{{ route('admin.product.type.update', $type) }}" method="post">
            @csrf
            @method('patch')

            <div class="form-group">
                <label for="title">Название типа</label>
                <input type="text" id="title" name="title" class="form-control"
                       value="{{ old('title') ?? $type->title }}">
            </div>

            <div class="mt-5">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
