<header>
    <div class="container">
        <div class="row">
            <div class="column w-md-1/2 w-lg-1/3">
                <nav class="nav text-uppercase">
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
                </nav>
            </div>

            <div class="column"></div>

            <div class="column-auto">
                <app-cart></app-cart>
            </div>
        </div>
    </div>
</header>
