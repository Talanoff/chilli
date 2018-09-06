@if (in_array(app('router')->currentRouteName(), ['app.product.index', 'app.promotions', 'app.novelties']))
    <div class="filters flex">
        <ul class="filters-list unstyled">
            @if ($results)
                <li class="text-right mb-6">{{ $results }}</li>
            @endif

            <li class="filters-list-item mb-4">
                <a href="{{ route('app.novelties') }}" class="text-uppercase">
                    Новинки
                </a>
            </li>

            <li class="filters-list-item has-submenu mb-4">
                <div class="flex">
                    <a href="#price-sort" class="text-uppercase toggler-link">
                        По цене
                    </a>
                    <svg width="14" height="14" class="ml-2">
                        <use xlink:href="#caret"></use>
                    </svg>
                </div>

                <ul class="unstyled submenu" id="price-sort">
                    @foreach($filters['price'] as $key => $filter)
                        <li>
                            <a href="{{ route(app('router')->currentRouteName(), array_replace(request()->query(), ['price' => $key])) }}">
                                {{ $filter }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

            @isset($filters['categories'])
                <li class="filters-list-item has-submenu">
                    <div class="flex">
                        <a href="#category-sort" class="text-uppercase toggler-link">
                            Все аксессуары
                        </a>
                        <svg width="14" height="14" class="ml-2">
                            <use xlink:href="#caret"></use>
                        </svg>
                    </div>

                    <ul class="unstyled submenu" id="category-sort">
                        @foreach($filters['categories'] as $category)
                            <li>
                                <a href="{{ route(app('router')->currentRouteName(), array_replace(request()->query(), ['category' => $category->slug])) }}">
                                    {{ $category->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endisset

            @if ($results)
                <li>

                </li>
            @endif
        </ul>

        @isset($filters['brands'])
            <ul class="filters-brands unstyled text-center">
                @foreach($filters['brands'] as $brand)
                    <li{!! request('brand') === $brand->slug ? ' class="is-active"' : '' !!}>
                        <a href="{{ route('app.product.index', array_replace(request()->query(), ['brand' => $brand->slug])) }}">
                            <img src="{{ $brand->getFirstMediaUrl('brand') }}" alt="{{ $brand->name }}">
                        </a>
                    </li>
                @endforeach
            </ul>
        @endisset
    </div>
@endif
