@extends('layouts.admin', ['app_title' => 'Атрибуты'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Атрибуты
            @if (\App\Models\Product\AttributeType::count())
                <a href="{{ route('admin.product.attribute.create') }}" class="btn btn-secondary ml-3">
                    Создать новый
                </a>
            @endif
        </h1>
        @if (!\App\Models\Product\AttributeType::count())
            <div class="alert alert-info mb-5" style="margin-top: -2rem;">
                Для начала нужно <a class="btn btn-secondary" href="{{ route('admin.product.type.create') }}">создать
                    типы</a> атрибутов.
            </div>
        @endif

        @forelse($attributes as $attribute)
            @item(['attr' => $attribute, 'name' => 'product.attribute', 'category' => $attribute->type()->first()])
            @slot('title')
                @if ($attribute->type === 'color')
                    <div class="attribute-color mr-2"
                         style="background-color: {{ $attribute->value }};"></div>
                @endif
                {{ $attribute->value }}
            @endslot
            @enditem
        @empty
            <div class="text-center text-muted">
                Атрибуты пока не добавлены
            </div>
        @endforelse

        @if(request()->filled('category'))
            <div class="mt-5 text-center">
                <a href="{{ route('admin.product.attribute.index') }}" class="btn btn-secondary">
                    Все атрибуты
                </a>
            </div>
        @endif
    </section>

    {{ $attributes->appends(request()->except('page'))->links() }}

@endsection
