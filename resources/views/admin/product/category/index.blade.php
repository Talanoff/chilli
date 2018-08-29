@extends('layouts.admin', ['app_title' => 'Категории'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Категории
            <a href="{{ route('admin.product.category.create') }}" class="btn btn-secondary ml-3">
                Создать категорию
            </a>
        </h1>

        @forelse($categories as $category)
            @item(['attr' => $category, 'name' => 'product.category'])@enditem
        @empty
            <div class="text-center text-muted">
                Категории пока не добавлены
            </div>
        @endforelse

        @if(request()->filled('category'))
            <div class="mt-5 text-center">
                <a href="{{ route('admin.product.category.index') }}" class="btn btn-secondary">
                    Все категории
                </a>
            </div>
        @endif
    </section>

    {{ $categories->appends(request()->except('page'))->links() }}

@endsection
