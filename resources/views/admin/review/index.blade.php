@extends('layouts.admin', ['page_title' => 'Обзоры'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Обзоры
            <a href="{{ route('admin.review.create') }}" class="btn btn-secondary ml-3">
                Новый обзор
            </a>
        </h1>

        <div class="row">
            @forelse($reviews as $review)
                <div class="col-md-6">
                    <div class="item">
                        <div class="item-id">{{ $review->id }}</div>
                        <div class="item-header">
                            <a href="{{ route('admin.review.edit', $review) }}" class="video-preview"
                               style="background: url(https://img.youtube.com/vi/{{ $review->video_id }}/sddefault.jpg) 50% 50% / cover no-repeat;">
                            </a>

                            <h3>
                                <a href="{{ route('admin.review.edit', $review) }}" class="link link-underline">
                                    {{ $review->title }}
                                </a>
                            </h3>
                        </div>
                        <div class="item-footer mt-3 text-right">
                            <a href="{{ route('admin.review.edit', $review) }}"
                               class="btn btn-warning btn-sm">
                                <svg width="23" height="23">
                                    <use xlink:href="#refresh"></use>
                                </svg>
                            </a>

                            <a href="{{ route('admin.review.delete', $review) }}"
                               onclick="confirmDelete()"
                               class="btn btn-danger btn-sm">
                                <svg width="23" height="23" style="fill: #fff;">
                                    <use xlink:href="#delete"></use>
                                </svg>
                            </a>
                            <form action="{{ route('admin.review.delete', $review) }}"
                                  id="delete-form" method="post" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">Обзоры пока не добавлены...</div>
            @endforelse
        </div>
    </section>

    {{ $reviews->appends(request()->except('page'))->links() }}

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
