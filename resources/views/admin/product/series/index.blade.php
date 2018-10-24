@extends('layouts.admin', ['app_title' => 'Модели'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Модели
            <a href="{{ route('admin.product.series.create') }}" class="btn btn-secondary ml-3">
                Создать модель
            </a>
        </h1>

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

                                <p class="mb-0 d-flex align-items-center">
                                    <strong>Бренд:</strong>
                                    <a href="{{ route('admin.product.series.index', ['brand' => $item->brand->id]) }}" class="ml-2">
                                        <img src="{{ $item->brand->getFirstMediaUrl('brand') }}"
                                             style="max-height: 24px; max-width: 100px;">
                                    </a>
                                </p>
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
