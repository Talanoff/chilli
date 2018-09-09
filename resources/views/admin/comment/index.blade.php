@extends('layouts.admin', ['app_title' => 'Комментарии'])

@section('content')

    <section class="content">
        <h1 class="mb-5 h2 d-flex align-items-center">
            Комментарии
        </h1>

        @forelse($comments as $comment)
            <div class="item">
                <div class="item-header row justify-content-between">
                    <div class="col">
                        <p class="mb-1 text-muted">
                            {{ $comment->created_at->diffForHumans() }}
                        </p>
                        <a href="{{ route('admin.comment.edit', $comment) }}" class="link link-underline">
                            {{ str_limit($comment->message) }}
                        </a>
                    </div>
                    <div class="col-md-auto">
                        <span
                            class="rounded px-2 py-1 bg-{{ $comment->status === 'agreement' ? 'warning' : ($comment->status === 'approved' ? 'success text-white' : 'danger text-white') }}">
                        {{ App\Models\Comment\Comment::$STATUSES[$comment->status] }}
                        </span>
                    </div>
                </div>
                <div class="item-footer row mt-3">
                    <div class="col">
                        <p>
                            <span class="text-muted">Пользователь:</span>
                            <a href="{{ route('admin.user.show', $comment->user) }}"
                               class="font-weight-bold link link-underline">
                                {{ $comment->user->name }}
                            </a>
                        </p>
                        <p class="mb-0">
                            @php
                            $type = strtolower(class_basename($comment->commentable_type));
                            @endphp

                            <strong class="text-muted">{{ $type === 'product' ? 'Продукт' : 'Обзор' }}:</strong>
                            <a href="{{ route('app.'. $type .'.show', $comment->commentable) }}"
                               class="font-weight-bold link link-underline">
                                {{ $comment->commentable->title }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            Комментариев пока нет...
        @endforelse
    </section>

    {{ $comments->appends(request()->except('page'))->links() }}

@endsection
