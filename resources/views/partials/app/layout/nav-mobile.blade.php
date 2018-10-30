<app-mobile-nav class="none-lg">
    <ul class="text-uppercase text-center">
        @foreach($nav as $item)
            <li>
                <a href="{{ route($item['route']) }}">
                    {{ $item['name'] }}
                </a>

                @if (!empty($item['submenu']))
                    <div class="row" ref="brands">
                        @foreach($item['submenu'] as $submenu)
                            <div class="w-1/2 flex align-center justify-center brand column">
                                {{--<a href="{{ build_filter_url('app.product.index', ['brand' => $submenu['brand']]) }}">--}}
                                {{--{{ $submenu['name'] }}--}}
                                {{--</a>--}}
                                @if (!empty($submenu['models']))
                                    <a href="{{ build_filter_url('app.product.index', ['brand' => $submenu['brand']]) }}">
                                        <img src="{{ $submenu['models']['brand'] }}"
                                             class="models-menu__brand">
                                    </a>
                                    {{--
                                        <div class="models-menu">
                                            <div class="mb-3">
                                                <a href="{{ build_filter_url('app.product.index', ['brand' => $submenu['brand']]) }}">
                                                    <img src="{{ $submenu['models']['brand'] }}"
                                                         class="models-menu__brand">
                                                </a>
                                            </div>
                                            <ul>
                                                @foreach($submenu['models']['series'] as $model)
                                                    <li>
                                                        <a href="{{ build_filter_url('app.product.index', ['brand' => $submenu['brand'], 'model' => $model['model']]) }}">
                                                            {{ $model['name'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        --}}
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </li>
        @endforeach
        <li>
            <a href="{{ route('app.page', ['page' => 'warranty']) }}">
                Гарантии
            </a>
        </li>
        <li>
            <a href="{{ route('app.page', ['page' => 'delivery']) }}">
                Оплата и доставка
            </a>
        </li>
        <li>
            <a href="{{ route('app.page', ['page' => 'contacts']) }}">
                Контакты
            </a>
        </li>
            @auth
                <li>
                    <hr class="my-3">
                    @if (auth()->user()->hasRole('administrator'))
                        <a href="{{ route('admin.dashboard.index') }}">
                            Панель управления
                        </a>
                    @else
                        <a href="{{ route('app.profile.index') }}">Профиль</a>
                    @endif
                </li>
            @endauth

            @guest
                <li>
                    <a href="{{ route('register') }}">Регистрация</a>
                </li>
                <li>
                    <a href="{{ route('login') }}">Войти</a>
                </li>
            @else
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Выйти
                    </a>
                </li>
            @endguest
    </ul>
</app-mobile-nav>
