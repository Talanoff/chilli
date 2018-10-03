@extends('layouts.admin', ['page_title' => $page->title])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            {{ $page->title }}
        </h1>

        <form action="{{ route('admin.page.update', $page) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title') ?? $page->title }}"
                               required>
                    </div>

                    <wysiwyg id="body" name="body" label="Описание"
                             content="{{ old('body') ?? $page->body }}"></wysiwyg>

                    @include('partials.admin.meta.meta', ['meta' => $page->meta()->first()])
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">
                    Сохранить
                </button>
            </div>
        </form>
    </section>

@endsection
