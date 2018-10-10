@extends('layouts.admin', ['app_title' => 'Товары'])

@section('content')

    <section class="content">
        <div class="d-lg-flex">
            <h1 class="mb-5 h2 d-flex align-items-center">
                Товары
                <a href="{{ route('admin.product.create') }}" class="btn btn-secondary ml-3">
                    Создать новый
                </a>
                <a href="{{ route('admin.product.meta') }}" class="btn btn-outline-primary ml-3">
                    Мета информация раздела
                </a>
            </h1>

            <form method="post" action="{{ route('admin.product.search') }}"
                  class="ml-lg-5 flex-grow-1">
                @csrf
                <div class="d-flex">
                    <div class="flex-grow-1 mr-2">
                        <input type="search" name="search" placeholder="Артикл"
                               class="form-control" value="{{ $search ?? '' }}">
                    </div>
                    <div>
                        <button class="btn btn-secondary">Найти</button>
                    </div>
                </div>
            </form>
        </div>

        @forelse($products as $product)
            <div class="item">
                <div class="item-id">{{ $product->id }}</div>
                <div class="item-header row">
                    <div class="col-auto">
                        <a href="{{ route('admin.product.edit', $product) }}">
                            <img src="{{ $product->thumbnail }}" style="width: 100px">
                        </a>
                    </div>
                    <div class="col-sm-9 col-lg-6">
                        <h3>
                            <a href="{{ route('admin.product.edit', $product) }}"
                               class="link link-underline">
                                {{ $product->title }}
                            </a>
                        </h3>

                        <ul class="d-flex list-unstyled mb-0">
                            <li>
                                <span class="font-weight-bold">SKU:</span>
                                {{ $product->sku }}
                            </li>
                            <li class="ml-3">
                                <span class="font-weight-bold">Рейтинг:</span>
                                {{ $product->stars }}
                            </li>
                            <li class="ml-3">
                                <span class="font-weight-bold">Комментарии:</span>
                                {{ $product->comments()->count() }}
                            </li>
                        </ul>
                    </div>

                    @if ($product->in_stock)
                        <div class="col ml-auto">
                            <div><span class="bg-success text-white rounded px-2 py-1">Акционный</span></div>
                            <div>Скидка в <strong>{{ $product->discount ?? 0 }}%</strong></div>
                        </div>
                    @endif

                    <div class="col-md-auto ml-auto">
                        <h2 class="font-weight-bold">{{ $product->computed_price }} грн</h2>
                    </div>
                </div>

                <hr>

                <div class="item-footer row justify-content-end">
                    <div class="col">
                        <p class="mb-0 h5">
                            <a class="link link-dashed"
                               href="{{ route('admin.product.index', ['category' => $product->category->id]) }}">
                                {{ $product->category->title }}
                            </a>
                        </p>
                    </div>

                    <div class="col text-right">
                        <a href="{{ route('admin.product.edit', $product) }}"
                           class="btn btn-warning btn-sm">
                            <svg width="23" height="23">
                                <use xlink:href="#refresh"></use>
                            </svg>
                        </a>

                        <a href="{{ route('admin.product.delete', $product) }}"
                           onclick="confirmDelete({{ $product->id }})"
                           class="btn btn-danger btn-sm">
                            <svg width="23" height="23" style="fill: #fff;">
                                <use xlink:href="#delete"></use>
                            </svg>
                        </a>
                        <form action="{{ route('admin.product.delete', $product) }}"
                              id="delete-form-{{ $product->id }}" method="post" style="display: none;">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                @if ($search)
                    Товара с таким ID не найдено
                @else
                    Товары пока не добавлены
                @endif
            </div>
        @endforelse

        @if(request()->filled('category'))
            <div class="mt-5 text-center">
                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                    Все товары
                </a>
            </div>
        @endif
    </section>

    {{ $products->appends(request()->except('page'))->links() }}

@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            event.preventDefault();

            const agree = confirm('Уверены?');

            if (agree) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
