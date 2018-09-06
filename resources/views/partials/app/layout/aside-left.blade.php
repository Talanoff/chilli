<aside class="aside aside--left">
    <nav class="nav align-center text-uppercase">
        <a href="{{ route('app.warranty') }}" class="nav-item">
            Гарантии
        </a>
        <a href="{{ route('app.delivery') }}" class="nav-item">
            Оплата и доставка
        </a>
        <a href="{{ route('app.contacts') }}" class="nav-item">
            Контакты
        </a>

        @if (in_array(app('router')->currentRouteName(), ['app.product.index', 'app.promotions', 'app.novelties']))
            <a href="#filter" class="filter-link nav-item" ref="filter">
                Фильтр
                <svg width="26" height="26" class="ml-2 filter-icon">
                    <use xlink:href="#filter"></use>
                </svg>
            </a>
        @endif
    </nav>
</aside>
