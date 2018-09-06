@extends('layouts.admin', ['app_title' => $characteristic->value])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            @if ($characteristic->type === 'color')
                <div class="attribute-color mr-2"
                     style="background-color: {{ $characteristic->value }};"></div>
            @endif
            {{ $characteristic->value }}
        </h1>

        <form action="{{ route('admin.product.characteristic.update', $characteristic) }}" method="post">
            @csrf
            @method('patch')

            <attribute-creator
                ex-type="{{ $characteristic->type }}"
                ex-value="{{ $characteristic->value }}"
                :types="{{ $selectors }}"></attribute-creator>

            <div class="form-group">
                <label for="type">Тип атрибута</label>
                <select name="type_id" id="type" class="form-control">
                    @foreach($types as $type)
                        <option
                            value="{{ $type->id }}"{{ $type->id === $characteristic->type()->first()->id ? ' selected' : '' }}>
                            {{ $type->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-5">
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
