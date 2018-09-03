@extends('layouts.admin', ['app_title' => $product->title])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            {{ $product->title }}
        </h1>

        <form action="{{ route('admin.product.update', $product) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" name="title" id="title" class="form-control"
                               value="{{ old('title') ?? $product->title }}" required>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Подзаголовок</label>
                        <input type="text" name="subtitle" id="subtitle" class="form-control"
                               value="{{ old('subtitle') ?? $product->subtitle }}">
                    </div>

                    <div class="form-group">
                        <label for="category">Категория</label>
                        <select name="category_id" id="category" class="form-control" required>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"{{ $category->id === optional($product->category)->id ? ' selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <wysiwyg id="body" name="description" label="Описание"
                             content="{{ old('description') ?? $product->description }}"></wysiwyg>

                    <images-uploader existed-images="{{ json_encode($product->gallery_preview) }}"></images-uploader>

                    <hr class="mt-5">

                    <div class="form-group">

                        <ul class="list-unstyled">
                            @foreach($types as $type)
                                <li class="{{ $loop->index > 0 ? 'mt-3' : '' }}">
                                    <label>
                                        <span class="text-muted">{{ $loop->iteration }}.</span>
                                        {{ $type->title }}
                                    </label>

                                    <div class="d-flex flex-wrap">
                                        @foreach($type->characteristics as $attribute)
                                            <label class="attribute-item mr-2">
                                                <input type="checkbox" name="attribute[]"
                                                       {{ $product->characteristics->contains($attribute->id) ? ' checked' : '' }}
                                                       value="{{ $attribute->id }}" class="mr-1">
                                                @if ($attribute->type === 'text')
                                                    {{ $attribute->value }}
                                                @elseif($attribute->type === 'color')
                                                    <span class="attribute-color attribute-color--small d-inline-block"
                                                          style="background-color: {{ $attribute->value }}"></span>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="price">Цена, грн</label>
                        <input type="number" min="0" name="price" id="price" class="form-control"
                               value="{{ old('price') ?? $product->price }}" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Количество, шт</label>
                        <input type="number" min="0" name="quantity" id="quantity" class="form-control"
                               value="{{ old('quantity') ?? $product->quantity }}">
                    </div>

                    <div class="form-group">
                        <label for="rate" class="mb-0">Рейтинг</label>
                        <p class="mb-2 text-muted">
                            <small>Если не заполнено, рейтинг будет расчитан автоматически</small>
                        </p>
                        <input type="number" min="0" max="5" id="rate" name="rating" class="form-control"
                               value="{{ old('rating') ?? $product->rating }}">
                    </div>

                    <div class="form-group">
                        <label for="tags">Тэги</label>
                        <select name="tag" id="tags" class="form-control">
                            <option value="">-----</option>
                            @foreach($tags as $key => $tag)
                                <option value="{{ $key }}"{{ $product->tag == $key ? ' selected' : '' }}>
                                    {{ $tag }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="mt-4 mb-3">

                    <div class="form-group">
                        <label for="discount">Скидка, %</label>
                        <input type="number" min="0" name="discount" id="discount" class="form-control"
                               value="{{ old('discount') ?? $product->discount }}">
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="hidden" name="in_stock" value="0">
                            <input type="checkbox" name="in_stock" value="1"{{ $product->in_stock ? ' checked' : '' }}>
                            Акционный
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="mb-2">
                    <label>
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published"
                               value="1"{{ $product->is_published ? ' checked' : '' }}>
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
