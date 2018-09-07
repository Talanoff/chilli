@extends('layouts.admin')

@section('content')

    <section class="content">

        @foreach($users as $user)
            <div class="item">
                <div class="item-id">{{ $user->id }}</div>
                <div class="item-header row">
                    <div class="col-sm-9 col-lg-7">
                        <h3>
                            <a href="{{ route('admin.user.edit', $user) }}" class="link link-underline">
                                {{ $user->name }}
                            </a>
                        </h3>
                    </div>
                    <div class="col-auto">
                        <h5>
                            <a href="mailto:{{ $user->email }}" class="link link-dashed">
                                {{ $user->email }}
                            </a>
                        </h5>
                        @if($user->phone)
                        <h5>
                            <a href="tel:{{ $user->phone }}" class="link link-dashed">
                                {{ $user->phone }}
                            </a>
                        </h5>
                        @endif
                    </div>
                </div>
                <div class="item-footer d-flex justify-content-end">
                    <div class="item-footer__actions">
                        <a href="{{ route('admin.user.edit', $user) }}"
                           class="btn btn-warning btn-sm">
                            Редактировать
                        </a>

                        <a href="{{ route('admin.user.delete', $user) }}"
                           onclick="confirmDelete()"
                           class="btn btn-danger btn-sm">
                            Удалить
                        </a>
                        <form action="{{ route('admin.user.delete', $user) }}"
                              id="delete-form" method="post" style="display: none;">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </section>

    {{ $users->appends(request()->except('page'))->links() }}

@endsection
