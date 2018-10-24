@extends('layouts.admin', ['app_title' => $brand->name])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex">
            <div class="text-center">
                @if ($brand->getFirstMediaUrl('brand'))
                    <div class="mb-2">
                        <img src="{{ $brand->getFirstMediaUrl('brand') }}" alt="{{ $brand->name }}" class="brand-image">
                    </div>
                @endif
                {{ $brand->name }}
            </div>
        </h1>

        <form action="{{ route('admin.product.brand.update', $brand) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') ?? $brand->title }}">
            </div>

            <div class="form-group">
                <label for="image">Выбрать логотип</label>
                <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
            </div>

            <div class="mt-5">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
