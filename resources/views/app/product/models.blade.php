@extends('layouts.app', ['app_title' => 'Каталог'])

@section('content')

    <section class="px-md-6 py-md-4 px-lg-10">
        <h1>
            <img src="{{ $brand->getFirstMediaUrl('brand') }}" alt="{{ $brand->title }}" style="max-width: 200px; max-height: 100px;">
        </h1>

        <div class="row">
            @forelse($models as $key => $chunk)
                <ul class="column w-md-1/2 w-lg-1/3 unstyled">
                    @foreach($chunk as $model)
                        <li class="flex">
                            <span class="text-danger small" style="flex: 0 0 0.9rem">{{ $loop->iteration + (15 * $key) }}</span>
                            <a href="{{ build_filter_url(['brand' => $brand->slug, 'model' => $model->slug], 'app.product.index') }}"
                               class="text-white text:hover-primary">{{ $model->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @empty
                Для {{ $brand->title }} модели не заданы...
            @endforelse
        </div>
    </section>

@endsection
