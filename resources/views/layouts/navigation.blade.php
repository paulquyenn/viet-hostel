<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Trang chủ') }}
                    </x-nav-link>

                    <x-nav-link :href="route('motel')" :active="request()->routeIs('motel')">
                        {{ __('Tìm phòng') }}
                    </x-nav-link>

                    <x-nav-link :href="route('rental-requests.index')" :active="request()->routeIs('rental-requests.*')">
                        {{ __('Yêu cầu thuê') }}
                    </x-nav-link>

                    @if (Auth::user()->hasRole(['landlord', 'admin']))
                        <x-nav-link :href="route('landlord.rental-requests')" :active="request()->routeIs('landlord.rental-requests')">
                            {{ __('Quản lý yêu cầu thuê') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.contract-management')" :active="request()->routeIs('admin.contract-management')">
                            {{ __('Quản lý hợp đồng (Admin)') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.*')">
                        {{ __('Hợp đồng') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Notifications Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 mr-3">
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-3">
                            <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-2">
                                <h3 class="text-sm font-semibold text-gray-800">Thông báo</h3>
                                <a href="{{ route('notifications.index') }}"
                                    class="text-xs text-blue-600 hover:text-blue-800">
                                    Xem tất cả
                                </a>
                            </div>

                            @if (Auth::user()->notifications->isEmpty())
                                <div class="py-2 px-1 text-sm text-gray-500">
                                    Không có thông báo nào.
                                </div>
                            @else
                                <div class="max-h-64 overflow-y-auto">
                                    @foreach (Auth::user()->notifications->take(5) as $notification)
                                        <div
                                            class="py-2 hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-blue-50' }} rounded-md px-1">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $notification->data['title'] }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                            <a href="{{ isset($notification->data['url']) ? url($notification->data['url']) : '#' }}"
                                                class="mt-1 block text-xs text-blue-600 hover:text-blue-800">
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Trang chủ') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('motel')" :active="request()->routeIs('motel')">
                {{ __('Tìm phòng') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('rental-requests.index')" :active="request()->routeIs('rental-requests.*')">
                {{ __('Yêu cầu thuê') }}
            </x-responsive-nav-link>

            @if (Auth::user()->hasRole(['landlord', 'admin']))
                <x-responsive-nav-link :href="route('landlord.rental-requests')" :active="request()->routeIs('landlord.rental-requests')">
                    {{ __('Quản lý yêu cầu thuê') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.contract-management')" :active="request()->routeIs('admin.contract-management')">
                    {{ __('Quản lý hợp đồng (Admin)') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('contracts.index')" :active="request()->routeIs('contracts.*')">
                {{ __('Hợp đồng') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
