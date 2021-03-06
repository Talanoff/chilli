@extends('layouts.admin', ['app_title' => 'Новая модель'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Новая модель
        </h1>

        <form action="{{ route('admin.product.series.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="title">Название модели</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <wysiwyg id="body" name="description" label="Описание" content="{{ old('description') }}"></wysiwyg>

            <div class="form-group{{ $errors->has('brand_id') ? ' is-invalid' : '' }}">
                <label for="brand">Бренд</label>
                <select name="brand_id" id="brand" class="form-control">
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                            {{ $brand->title }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('brand_id'))
                    <div class="mt-1 text-danger">
                        {{ $errors->first('brand_id') }}
                    </div>
                @endif
            </div>

            <div class="mt-5">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
