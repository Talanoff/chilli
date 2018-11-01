@extends('layouts.admin', ['app_title' => $user->name])

@section('content')

    <section class="content">
        <form action="{{ route('admin.user.update', $user) }}" method="post" id="edit-form">
            @csrf
            @method('patch')

            <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name') ?? $user->name }}" required>
                @if($errors->has('name'))
                    <div class="mt-1 text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email"
                               value="{{ old('email') ?? $user->email }}" required readonly>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group{{ $errors->has('role_id') ? ' is-invalid' : '' }}">
                        <label for="role">Роль</label>
                        <select name="role_id" id="role" class="form-control">
                            @foreach(\App\Models\User\Role::get() as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('role_id'))
                            <div class="mt-1 text-danger">
                                {{ $errors->first('role_id') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="form-group{{ $errors->has('phone') ? ' is-invalid' : '' }}">
                        <label for="phone">Телефон</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                               value="{{ old('phone') ?? $user->phone }}" required>
                        @if($errors->has('phone'))
                            <div class="mt-1 text-danger">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label for="birthday">Дата рождения</label>
                        <input type="date" class="form-control" id="birthday" name="birthday"
                               value="{{ old('birthday') ?? $user->birthday->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
        </form>

        <div class="d-flex mt-4">
            <button class="btn btn-primary" onclick="document.getElementById('edit-form').submit()">
                Сохранить
            </button>

            @if (auth()->user()->hasRole('administrator'))
                <form action="{{ route('admin.user.delete', $user) }}" method="post" class="ml-3">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger">
                        Удалить
                    </button>
                </form>
            @endif
        </div>
    </section>

@endsection
