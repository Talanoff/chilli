<aside id="app-aside">
    <nav>
        <ul class="list-unstyled mb-0 mh-100 accordion">
            @foreach($nav as $item)
                <li id="submenu-heading-{{ $loop->iteration }}"
                    class="nav-item{{ app('router')->currentRouteNamed($item['compare']) ? ' is-active' : '' }}">
                    @isset($item['unread'])
                    <div class="unread">{{ $item['unread'] }}</div>
                    @endisset

                    @isset($item['submenu'])
                        <a href="{!! route($item['route']) !!}" class="d-flex align-items-center"
                           data-toggle="collapse" data-target="#submenu-{{ $loop->iteration }}"
                           aria-expanded="{{ app('router')->currentRouteNamed($item['compare']) ? 'true' : 'false' }}"
                           aria-controls="submenu-{{ $loop->iteration }}">
                            <svg width="40" height="40">
                                <use xlink:href="#{{ $item['icon'] }}"></use>
                            </svg>
                            <span class="ml-3">{{ $item['name'] }}</span>
                        </a>
                        <ul id="submenu-{{ $loop->iteration }}"
                            class="submenu text-left collapse list-unstyled mb-0{{ app('router')->currentRouteNamed($item['compare']) ? ' show' : ''}}"
                            aria-labelledby="submenu-heading-{{ $loop->iteration }}" data-parent="#app-aside">
                            @foreach($item['submenu'] as $submenu)
                                <li class="submenu-item {{ app('router')->currentRouteNamed('') }}">
                                    <a href="{!! route($submenu['route']) !!}">
                                        {{ $submenu['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a href="{!! route($item['route']) !!}" class="d-flex align-items-center">
                            <svg width="40" height="40">
                                <use xlink:href="#{{ $item['icon'] }}"></use>
                            </svg>
                            <span class="ml-3">{{ $item['name'] }}</span>
                        </a>
                    @endisset
                </li>
            @endforeach
        </ul>
    </nav>
</aside>
