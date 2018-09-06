<header>
    <div class="container">
        <div class="row align-center">
            <a href="{{ url('/') }}" class="logo column-auto">
                <img src="{{ asset('images/logo.png') }}" alt="Chilli">
            </a>

            <div class="column w-lg-1/2">
                <nav class="nav text-uppercase justify-between">
                    @foreach($nav as $item)
                        <a href="{{ route($item['route']) }}"
                           class="nav-item{{ app('router')->currentRouteNamed($item['compare']) ? ' is-active' : '' }}">
                            {{ $item['name'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="column"></div>

            <div class="column-auto">
                <app-cart></app-cart>
            </div>
        </div>
    </div>
</header>
