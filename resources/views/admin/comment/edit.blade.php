@extends('layouts.admin', ['app_title' => 'Коментарий'])

@section('content')

    <section class="content">
        <div class="row mb-4">
            <div class="col">
                <span class="text-muted">Пользователь:</span>
                <a href="{{ route('admin.user.show', $comment->user) }}"
                   class="font-weight-bold link link-underline">
                    {{ $comment->user->name }}
                </a>
            </div>
            <div class="col text-right">
                {{ $comment->created_at->formatLocalized('%d %B %Y в %H:%M') }}<br>
            </div>
        </div>

        <div class="mb-5">
            {{ $comment->message }}
        </div>

        <div class="d-flex">
            <form action="{{ route('admin.comment.update', $comment) }}" method="post">
                @csrf
                @method('patch')

                <input type="hidden" name="status"
                       value="{{ $comment->status === 'agreement' ? 'approved' : 'agreement' }}">

                <button class="btn btn-{{ $comment->status === 'agreement' ? 'success' : 'warning' }}">
                    {{ $comment->status === 'agreement' ? 'Подтвердить' : 'Снять с публикации' }}
                </button>
            </form>

            <form action="{{ route('admin.comment.update', $comment) }}" method="post" class="ml-2">
                @csrf
                @method('patch')

                <input type="hidden" name="status" value="declined">

                <button class="btn btn-danger">
                    Отклонить
                </button>
            </form>
        </div>
    </section>

@endsection
