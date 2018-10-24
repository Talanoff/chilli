@extends('layouts.admin', ['app_title' => 'Бренды'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Бренды
            <a href="{{ route('admin.product.brand.create') }}" class="btn btn-secondary ml-3">
                Создать новый
            </a>
        </h1>

        <div class="row">
            @forelse($brands as $brand)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="item">
                        <div class="item-header">
                            <div>
                                <a href="{{ route('admin.product.brand.edit', $brand) }}"
                                   class="d-flex align-items-center justify-content-center mx-auto mb-3" style=",max-width: 200px; height: 200px;">
                                    @if($brand->getFirstMediaUrl('brand'))
                                        <img src="{{ $brand->getFirstMediaUrl('brand') }}"
                                             style="max-height: 100%;">
                                    @else
                                        <span class="h3 link link-underline">{{ $brand->name }}</span>
                                    @endif
                                </a>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('admin.product.brand.edit', $brand) }}"
                                   class="btn btn-warning btn-sm">
                                    <svg width="23" height="23">
                                        <use xlink:href="#refresh"></use>
                                    </svg>
                                </a>

                                <a href="{{ route('admin.product.brand.delete', $brand) }}"
                                   onclick="confirmDelete({{ $brand->id }})"
                                   class="btn btn-danger btn-sm">
                                    <svg width="23" height="23" style="fill: #fff;">
                                        <use xlink:href="#delete"></use>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.product.brand.delete', $brand) }}"
                                      id="delete-form-{{ $brand->id }}" method="post" style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted col">
                    Бренды пока не добавлены
                </div>
            @endforelse
        </div>
    </section>

    {{ $brands->appends(request()->except('page'))->links() }}

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
