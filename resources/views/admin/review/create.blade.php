@extends('layouts.admin', ['page_title' => 'Новый обзор'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Новый обзор
        </h1>

        <form action="{{ route('admin.review.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}"
                               required>
                    </div>

                    <wysiwyg id="body" name="description" label="Описание" content="{{ old('description') }}"></wysiwyg>

                    <image-uploader></image-uploader>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="type">Тип записи</label>
                        <select name="type" id="type" class="form-control" ref="type">
                            @foreach(App\Models\Review\Review::$CATEGORIES as $type => $category)
                                <option value="{{ $type }}">
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="video-link">
                        <label for="video_url">Ссылка на видео (Youtube)</label>
                        <input type="text" id="video_url" name="video_url" class="form-control"
                               value="{{ old('video_url') }}">
                    </div>

                    <product-selector old="{{ old('product_id') }}"></product-selector>
                </div>
            </div>

            <div class="mt-4">
                <div class="mb-2">
                    <label>
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1">
                        Опубликовать
                    </label>
                </div>

                <button class="btn btn-primary">
                    Сохранить
                </button>
            </div>
        </form>
    </section>

@endsection
