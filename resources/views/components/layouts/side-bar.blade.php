<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach ($menus as $item)
            <li class="nav-item">
                @if (isset($item['submenus']))
                    <a class="nav-link collapsed" data-bs-target="{{ '#' . $item['key'] }}" data-bs-toggle="collapse"
                        href="#">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['name'] }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="{{ $item['key'] }}" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                        @foreach ($item['submenus'] as $submenu)
                            <li>
                                <a href="{{ route($submenu['route']) }}">
                                    <i class="bi bi-circle"></i><span>{{ $submenu['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <a class="nav-link" href="{{ route($item['route']) }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['name'] }}</span>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</aside>
