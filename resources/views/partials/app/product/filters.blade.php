<div class="filters flex flex-no-wrap">
    <ul class="filters-list unstyled">
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
                        <a href="{{ build_filter_url(app('router')->currentRouteName(), ['price' => $key]) }}">
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
                            <a href="{{ build_filter_url(app('router')->currentRouteName(), ['category' => $category->slug]) }}">
                                {{ $category->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endisset
    </ul>

    @isset($filters['brands'])
        <ul class="filters-brands unstyled text-center">
            @foreach($filters['brands'] as $brand)
                <li{!! request('brand') === $brand->slug ? ' class="is-active"' : '' !!}>
                    <a href="{{ build_filter_url('app.product.index', ['brand' => $brand->slug]) }}">
                        <img src="{{ $brand->getFirstMediaUrl('brand') }}" alt="{{ $brand->name }}">
                    </a>
                </li>
            @endforeach
        </ul>
    @endisset
</div>
