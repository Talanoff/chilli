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
                                <a href="{{ build_filter_url(['brand' => $submenu['brand'], 'model' => 'any'], 'app.product.index') }}">
                                    {{ $submenu['name'] }}
                                </a>
                                @if (!empty($submenu['models']))
                                    <div class="models-menu">
                                        <div class="mb-3">
                                            <a href="{{ build_filter_url(['brand' => $submenu['brand'], 'model' => 'any'], 'app.product.index') }}">
                                                <img src="{{ $submenu['models']['brand'] }}"
                                                     class="models-menu__brand">
                                            </a>
                                        </div>

                                        @if (!empty($submenu['models']['series']))
                                            <div class="row smaller">
                                                @foreach($submenu['models']['series'] as $models)
                                                    @if ($loop->index === 3)
                                                        <div class="my-3">
                                                            <button class="btn btn-primary">
                                                                Показать больше моделей
                                                            </button>
                                                        </div>
                                                    @endif

                                                    <div
                                                        class="column w-md-1/2{{ count($submenu['models']['series']) > 2 ? ' w-lg-1/3' : '' }}{{ $loop->index > 2 ? ' extra-models' : '' }}">
                                                        <ul class="unstyled">
                                                            @foreach($models as $model)
                                                                <li>
                                                                    <a href="{{ build_filter_url(['brand' => $submenu['brand'], 'model' => $model->slug], 'app.product.index') }}">
                                                                        {{ $model->title }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
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
