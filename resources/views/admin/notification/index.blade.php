@extends('layouts.admin', ['app_title' => 'Уведомления'])

@section('content')

    <section id="content">
        @forelse($notifications as $notification)
            <div class="item">
                <div class="row">
                    <div class="col-auto pr-0">
                        {{ $notification->id }}.
                    </div>
                    <div class="col">
                        Пользователь:<br>
                        @if ($notification->user_id)
                            <span
                                class="bg-warning px-1 rounded-circle small mr-1">{{ $notification->user->id }}</span>
                            <a href="{{ route('admin.user.edit', $notification->user) }}"
                               class="link link-underline">
                                {{ $notification->user->name }}
                            </a>
                        @else
                            <a href="mailto:{{ $notification->email }}">
                                {{ $notification->email }}
                            </a>
                        @endif
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('admin.notification.status', $notification) }}" method="post">
                            @csrf
                            @method('patch')
                            <select name="status" class="form-control"
                                    onchange="this.parentNode.submit()">
                                @foreach(\App\Models\Product\Notification::$STATUSES as $key => $status)
                                    <option value="{{ $key }}" {{ $key === $notification->status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            ...
        @endforelse

        {{ $notifications->links() }}
    </section>

@endsection
