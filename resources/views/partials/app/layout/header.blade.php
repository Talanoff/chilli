<header>
    <div class="container">
        <div class="row align-center nav-container">
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

            <div class="column">
                {{-- search --}}
            </div>

            <div class="column-auto">
                <app-cart></app-cart>
            </div>
        </div>

        <ul class="flex justify-end unstyled">
            @foreach($settings['phone'] as $phone)
                <li class="ml-4">
                    <svg width="14" height="14" style="margin-top: -2px;">
                        <use xlink:href="#{{ phone_icon($phone->value) }}"></use>
                    </svg>
                    <a href="tel:{{ phone_link($phone->value) }}">
                        {{ $phone->value }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</header>
