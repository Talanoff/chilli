<div class="column w-lg-1/2 none block-lg">
    <ul class="nav nav--desktop text-uppercase justify-between">
        @foreach($nav as $item)
            <li class="nav-item{{ app('router')->currentRouteNamed($item['compare']) ? ' is-active' : '' }}">
                <a href="{{ route($item['route']) }}">
                    {{ $item['name'] }}
                </a>

                @if (!empty($item['submenu']))
                    <ul class="submenu">
                        @foreach($item['submenu'] as $submenu)
                            <li class="{{ !empty($submenu['models']) ? 'has-submenu' : '' }}">
                                <a href="{{ build_filter_url('app.product.index', ['brand' => $submenu['brand']]) }}">
                                    {{ $submenu['name'] }}
                                </a>
                                @if (!empty($submenu['models']))
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
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>
