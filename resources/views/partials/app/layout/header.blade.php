<header>
    <div class="container">
        <div class="row align-center nav-container">
            <a href="{{ url('/') }}" class="logo column-auto">
                <img src="{{ asset('images/logo.png') }}" alt="Chilli">
            </a>

            @include('partials.app.layout.nav-desktop')

            <div class="column-auto ml-auto flex align-center justify-end">
                <form action="{{ route('app.product.search') }}" method="post" class="flex-1 none block-lg" name="search-form">
                    @csrf
                    <app-search></app-search>
                </form>

                <app-favourites class="ml-3"></app-favourites>

                <app-cart class="ml-3"></app-cart>
            </div>
        </div>

        <div class="flex none-lg mt-2">
            <div class="w-100">
                @include('partials.app.layout.nav-mobile')
            </div>
        </div>

        @if (count($settings['phone']))
            <ul class="flex justify-center justify-lg-end unstyled phones mt-8 mt-lg-0    ">
                @foreach($settings['phone'] as $phone)
                    <li class="mx-2 {{ $loop->last ? ' mr-lg-0' : '' }}">
                        <svg width="14" height="14" style="margin-top: -2px;">
                            <use xlink:href="#{{ phone_icon($phone->value) }}"></use>
                        </svg>
                        <a href="tel:{{ phone_link($phone->value) }}">
                            {{ $phone->value }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</header>
