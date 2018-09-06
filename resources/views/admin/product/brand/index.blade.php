@extends('layouts.admin', ['app_title' => 'Бренды'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Бренды
            <a href="{{ route('admin.product.brand.create') }}" class="btn btn-secondary ml-3">
                Создать новый
            </a>
        </h1>

        @forelse($brands as $brand)
            <div class="item">
                <div class="item-id">{{ $brand->id }}</div>
                <div class="item-header row justify-content-between">
                    <div class="col">
                        <a href="{{ route('admin.product.brand.edit', $brand) }}" class="d-flex align-items-center">
                            @if($brand->getFirstMediaUrl('brand'))
                                <img src="{{ $brand->getFirstMediaUrl('brand') }}" style="height: 40px;" class="mr-3">
                            @else
                                <span class="h3 link link-underline">{{ $brand->name }}</span>
                            @endif
                        </a>
                    </div>

                    <div class="col text-right">
                        <a href="{{ route('admin.product.brand.edit', $brand) }}"
                           class="btn btn-warning btn-sm">
                            <svg width="23" height="23">
                                <use xlink:href="#refresh"></use>
                            </svg>
                        </a>

                        <a href="{{ route('admin.product.brand.delete', $brand) }}"
                           onclick="confirmDelete()"
                           class="btn btn-danger btn-sm">
                            <svg width="23" height="23" style="fill: #fff;">
                                <use xlink:href="#delete"></use>
                            </svg>
                        </a>
                        <form action="{{ route('admin.product.brand.delete', $brand) }}"
                              id="delete-form" method="post" style="display: none;">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">
                Бренды пока не добавлены
            </div>
        @endforelse
    </section>

    {{ $brands->appends(request()->except('page'))->links() }}

@endsection

@push('scripts')
    <script>
        function confirmDelete() {
            event.preventDefault();

            const agree = confirm('Уверены?');

            if (agree) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endpush
