<!-- Sticky Navbar with Dropdown -->
<nav class="bg-white shadow-lg fixed w-full z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center">
                    <x-application-logo class="h-8 w-8" />
                </a>
                <div class="hidden md:ml-6 md:flex md:space-x-8">
                    <a href="{{ route('dashboard') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Trang chủ
                    </a>
                    <a href="{{ route('motel') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Nhà trọ
                    </a>
                    <a href="{{ route('about') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Giới thiệu
                    </a>
                    <a href="{{ route('contact') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Liên hệ
                    </a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="hidden md:ml-4 md:flex md:items-center md:space-x-3">
                    @auth
                        <!-- User is logged in -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" type="button"
                                class="flex items-center space-x-2 text-sm rounded-full focus:outline-none"
                                id="user-menu-button">
                                <img class="h-8 w-8 rounded-full"
                                    src="{{ auth()->user()->profile_photo_url ?? asset('images/avatar-placeholder.png') }}"
                                    alt="{{ auth()->user()->name }}">
                                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" @click.outside="open = false"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95">

                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Hồ sơ cá nhân
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- User is not logged in -->
                        <a href="{{ route('login') }}"
                            class="bg-white border border-indigo-600 text-indigo-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-indigo-600 px-4 py-2 rounded-md text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Đăng ký
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Trang chủ
            </a>
            <a href="{{ route('motel') }}"
                class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Nhà trọ
            </a>
            <a href="{{ route('about') }}"
                class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Giới thiệu
            </a>
            <a href="{{ route('contact') }}"
                class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Liên hệ
            </a>
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                @auth
                    <!-- User info for mobile -->
                    <div class="flex items-center w-full">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                src="{{ auth()->user()->avatar ?? asset('images/avatar-placeholder.png') }}"
                                alt="{{ auth()->user()->name }}">
                        </div>
                        <div class="ml-3 w-full">
                            <div class="text-base font-medium text-gray-800">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ auth()->user()->email }}
                            </div>

                            <div class="mt-3 space-y-1">

                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    Hồ sơ cá nhân
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="w-full space-y-2">
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-white border border-indigo-600 text-indigo-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-50">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center bg-indigo-600 px-4 py-2 rounded-md text-white text-sm font-medium hover:bg-indigo-700">
                            Đăng ký
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Simple toggle for mobile menu
    document.querySelector('button[aria-expanded]').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('hidden');
    });
</script>
