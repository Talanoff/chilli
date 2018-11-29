<footer>
    <div class="container">
        <hr class="{{ app('router')->currentRouteName() === 'app.home' ? 'mt-0' : '' }}">

        <div class="row">
            <div class="column w-md-1/5 text-center">
                <p>
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Chilli">
                    </a>
                </p>

                @if ($settings['social'])
                    <ul class="unstyled flex justify-around">
                        @foreach($settings['social'] as $social)
                            <li>
                                <a href="{{ $social->value }}" class="icon-{{ $social->name }}" target="_blank">
                                    <svg width="24" height="24">
                                        <use xlink:href="#{{ $social->name }}"></use>
                                    </svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="column w-md-4/5">
                <nav class="smaller">
                    <ul class="nav block flex-md flex-wrap text-uppercase justify-between my-5">
                        @foreach($nav as $item)
                            <li class="nav-item my-3 my-md-0 text-center text-md-left {{ $loop->index === 0 ? 'ml-0' : '' }}">
                                <a href="{{ route($item['route']) }}">
                                    {{ $item['name'] }}
                                </a>
                            </li>
                        @endforeach
                        <li class="nav-item my-3 my-md-0 text-center text-md-left">
                            <a href="{{ route('app.page', ['page' => 'contacts']) }}">
                                Контакты
                            </a>
                        </li>
                        <li class="nav-item my-3 my-md-0 text-center text-md-left">
                            <a href="{{ route('app.page', ['page' => 'delivery']) }}">
                                Оплата и доставка
                            </a>
                        </li>
                        <li class="nav-item my-3 my-md-0 text-center text-md-left mr-0">
                            <a href="{{ route('app.page', ['page' => 'exchange']) }}">
                                Обмен и возврат
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="row text-uppercase text-center text-md-left contacts">
                    @if (count($settings['phone']))
                        <div class="column column-md-auto my-3 my-md-0">
                            <p class="mb-1">Телефон</p>
                            <a class="text-bold text-white"
                               href="tel:{{ phone_link($settings['phone']->last()->value) }}">
                                {{ $settings['phone']->last()->value }}
                            </a>
                        </div>
                    @endif
                    @if ($settings['email'])
                        <div class="column column-md-auto mb-3 mb-md-0">
                            <p class="mb-1">Почта</p>
                            <a class="text-bold text-white" href="mailto:{{ $settings['email']->first()->value }}">
                                {{ $settings['email']->first()->value }}
                            </a>
                        </div>
                    @endif
                    <div class="column w-lg-1/2 ml-auto">
                        <p class="text-white text-bold mb-1">
                            Подписаться на рассылку новинок
                        </p>
                        <form action="{{ route('app.subscribe') }}" method="post" class="subscribe-form flex">
                            @csrf
                            <input type="text" name="email" class="form-control" placeholder="Ваш e-mail">
                            <button class="btn btn-secondary">
                                <svg width="22" height="22">
                                    <use xlink:href="#plane"></use>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="text-center">
            <div>Дизайн и разработка <a href="#" class="text-bold text-uppercase">Impression bureau</a></div>
            <div>
                &copy; {{ date('Y') }} Все права защищены.
                <a href="{{ route('app.page', ['page' => 'privacy']) }}" class="ml-4">
                    Политика конфиденциальности
                </a>
            </div>
        </div>
    </div>
</footer>
