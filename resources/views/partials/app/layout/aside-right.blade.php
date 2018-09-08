<aside class="aside aside--right">
    <nav class="nav align-center text-uppercase">
        @auth
            @if (auth()->user()->hasRole('administrator'))
                <a href="{{ route('admin.dashboard.index') }}" class="nav-item">
                    Панель управления
                </a>
            @else
                <a href="{{ route('app.profile.index') }}" class="nav-item">Профиль</a>
            @endif
        @endauth

        @guest
            <a href="{{ route('register') }}" class="nav-item">Регистрация</a>
            <a href="{{ route('login') }}" class="nav-item">Войти</a>
        @else
            <a href="{{ route('logout') }}" class="nav-item"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Выйти
            </a>
        @endguest
    </nav>
</aside>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
