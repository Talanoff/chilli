<footer>
    <div class="container">
        <hr class="{{ app('router')->currentRouteName('app.home') ? 'mt-0' : '' }}">

        <div class="row">
            <div class="column w-md-1/5"></div>
            <div class="column w-md-4/5">
                <nav class="nav text-uppercase justify-between">
                    @foreach($nav as $item)
                        <a href="{{ route($item['route']) }}" class="nav-item">
                            {{ $item['name'] }}
                        </a>
                    @endforeach
                    <a href="{{ route('app.warranty') }}" class="nav-item">
                        Гарантии
                    </a>
                    <a href="{{ route('app.delivery') }}" class="nav-item">
                        Оплата и доставка
                    </a>
                    <a href="{{ route('app.contacts') }}" class="nav-item">
                        Контакты
                    </a>
                </nav>
            </div>
        </div>

        <hr>

        <div class="text-center">
            <div>Дизайн и разработка <a href="#" class="text-bold text-uppercase">Impression bureau</a></div>
            <div>&copy; {{ date('Y') }} Все права защищены</div>
        </div>
    </div>
</footer>
