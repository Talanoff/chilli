@extends('layouts.admin', ['app_title' => 'Новый атрибут'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Новый атрибут
        </h1>

        <form action="{{ route('admin.product.characteristic.store') }}" method="post">
            @csrf

            <attribute-creator :types="{{ $selectors }}"></attribute-creator>

            <div class="form-group">
                <label for="type">Тип атрибута</label>
                <select name="type_id" id="type" class="form-control">
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-5">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
