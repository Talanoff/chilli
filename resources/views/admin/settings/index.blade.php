@extends('layouts.admin', ['app_title' => 'Настройки'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Настройки
        </h1>

        @forelse($settings as $key => $setting)
            <div class="mb-5">
                <h4>{{ App\Models\Setting\Setting::$TYPES[$key] }}</h4>
                @foreach($setting as $item)
                    <form action="{{ route('admin.settings.update', $item) }}" method="post">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    @if ($key === 'phone')
                                        <input type="tel" name="value" class="form-control"
                                               value="{{ $item->value }}" placeholder="___ ___ __ __">
                                    @elseif($key === 'email')
                                        <input type="email" name="value" class="form-control"
                                               value="{{ $item->value }}" placeholder="email@gmail.com">
                                    @elseif($key === 'social')
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" name="name" class="form-control"
                                                       value="{{ $item->name }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" name="value" class="form-control"
                                                       value="{{ $item->value }}">
                                            </div>
                                        </div>
                                    @else
                                        <input type="text" name="name" class="form-control mb-2"
                                               value="{{ $item->name }}">
                                        <textarea name="value" rows="3"
                                                  class="form-control">{!! $item->value !!}</textarea>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-secondary">
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        @empty
            ...
        @endforelse
    </section>

@endsection
