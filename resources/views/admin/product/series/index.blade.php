@extends('layouts.admin', ['app_title' => 'Модели'])

@section('content')

    <section class="content">
        <h1 class="mb-4 h2 d-flex align-items-center">
            Модели
            <a href="{{ route('admin.product.series.create') }}" class="btn btn-secondary ml-3">
                Создать модель
            </a>
        </h1>

        <div class="mb-4 d-flex flex-wrap justify-content-center">
            @foreach($brands as $brand)
                <a href="{{ route('admin.product.series.index', ['brand' => $brand->id]) }}"
                   class="btn btn-dark mx-1 my-1">
                    <img src="{{ $brand->getFirstMediaUrl('brand') }}" style="height: 20px;" alt="">
                </a>
            @endforeach
        </div>

        <div class="row">
            @forelse($series as $item)
                <div class="col-md-6">
                    <article class="item">
                        <div class="row">
                            <div class="col">
                                <h4>
                                    <a href="{{ route('admin.product.series.edit', $item) }}"
                                       class="link-underline link">{{ $item->title }}</a>
                                </h4>
                            </div>

                            <div class="col-auto text-right">
                                <a href="{{ route('admin.product.series.edit', $item) }}"
                                   class="btn btn-warning btn-sm">
                                    <svg width="23" height="23">
                                        <use xlink:href="#refresh"></use>
                                    </svg>
                                </a>

                                <a href="{{ route('admin.product.series.delete', $item) }}"
                                   onclick="confirmDelete({{ $item->id }})"
                                   class="btn btn-danger btn-sm">
                                    <svg width="23" height="23" style="fill: #fff;">
                                        <use xlink:href="#delete"></use>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.product.series.delete', $item) }}"
                                      id="delete-form-{{ $item->id }}" method="post" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mt-2">
                            <div class="flex-shrink-0">
                                Бренд:
                                <a href="{{ route('admin.product.series.index', ['brand' => $item->brand->id]) }}"
                                   class="ml-2 font-weight-bold">
                                    {{ $item->brand->title }}
                                </a>
                            </div>

                            <div class="d-flex align-items-center ml-auto">
                                Порядок:
                                <form action="{{ route('admin.product.series.update', $item) }}" class="ml-2" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="order" class="form-control d-inline-flex"
                                           onchange="this.parentElement.submit()" value="{{ old('order') ?? $item->order }}" style="width: 100px;">
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="text-center text-muted col">
                    Модели пока не добавлены
                </div>
            @endforelse
        </div>
    </section>

    {{ $series->appends(request()->except('page'))->links() }}

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
