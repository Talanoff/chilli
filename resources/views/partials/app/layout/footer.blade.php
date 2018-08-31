<footer>
    <div class="container">
        <hr>

        <div class="row">
            <div class="column w-md-1/5"></div>
            <div class="column w-md-4/5">
                <nav class="nav text-uppercase justify-between">
                    <a href="{{ route('app.product.index') }}" class="nav-item">
                        Каталог
                    </a>
                    <a href="{{ route('app.product.promotions') }}" class="nav-item">
                        Акции
                    </a>
                    <a href="{{ route('app.product.novelties') }}" class="nav-item">
                        Новинки
                    </a>
                    <a href="{{ route('app.review.index') }}" class="nav-item">
                        Обзоры
                    </a>
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
