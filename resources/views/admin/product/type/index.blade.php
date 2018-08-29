@extends('layouts.admin', ['app_title' => 'Типы атрибутов'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Типы атрибутов
            <a href="{{ route('admin.product.type.create') }}" class="btn btn-secondary ml-3">
                Создать тип
            </a>
        </h1>

        @forelse($types as $type)
            @item(['attr' => $type, 'name' => 'product.type'])@enditem
        @empty
            <div class="text-center text-muted">
                Категории пока не добавлены
            </div>
        @endforelse
    </section>

@endsection
