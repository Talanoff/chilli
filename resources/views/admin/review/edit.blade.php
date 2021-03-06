@extends('layouts.admin', ['page_title' => $review->title])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            {{ $review->title }}
        </h1>

        <form action="{{ route('admin.review.update', $review) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title') ?? $review->title }}"
                               required>
                    </div>

                    <wysiwyg id="body" name="description" label="Описание"
                             content="{{ old('description') ?? $review->description }}"></wysiwyg>

                    <image-uploader src="{{ $review->getFirstMediaUrl('review') }}"
                                    image-id="{{ optional($review->getFirstMedia('review'))->id }}"></image-uploader>

                    @include('partials.admin.meta.meta')
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
                               value="{{ old('video_url') ?? $review->video_url }}">
                    </div>

                    <product-selector old="{{ old('product_id') ?? $review->product_id }}"></product-selector>
                </div>
            </div>

            <div class="mt-4">
                <div class="mb-2">
                    <label>
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published"
                               value="1"{{ $review->is_published ? ' checked' : '' }}>
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
