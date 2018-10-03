@extends('layouts.admin', ['page_title' => 'Страницы'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Страницы
            {{--<a href="{{ route('admin.page.create') }}" class="btn btn-secondary ml-3">--}}
                {{--Новый обзор--}}
            {{--</a>--}}
        </h1>

        <div class="row">
            @forelse($pages as $page)
                <div class="col-md-6">
                    <div class="item">
                        <div class="item-header">
                            <div class="row align-items-end">
                                <div class="col">
                                    <h3 class="mb-1">
                                        <a href="{{ route('admin.page.edit', $page) }}" class="link link-underline">
                                            {{ $page->title }}
                                        </a>
                                    </h3>
                                </div>

                                <div class="col-auto">
                                    <a href="{{ route('admin.page.edit', $page) }}"
                                       class="btn btn-warning btn-sm">
                                        <svg width="23" height="23">
                                            <use xlink:href="#refresh"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col">Страницы пока не добавлены...</div>
            @endforelse
        </div>
    </section>

    {{ $pages->appends(request()->except('page'))->links() }}

@endsection
