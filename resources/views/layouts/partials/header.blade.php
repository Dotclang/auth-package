<header class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-4">
                <button id="sidebarToggle" type="button" aria-expanded="true"
                    class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <form class="hidden sm:flex items-center" action="#" method="GET">
                    <input name="q" type="search" placeholder="Search..."
                        class="px-3 py-2 border rounded-md bg-gray-50 dark:bg-gray-900 dark:border-gray-700 text-sm focus:outline-none" />
                </form>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <button id="darkModeToggle" type="button" aria-pressed="false" aria-controls="themeMenu"
                        aria-expanded="false" aria-live="polite"
                        class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span id="darkModeIcon" class="text-lg" aria-hidden="true">🌓</span>
                        <span id="darkModeLabel" class="sr-only sm:inline text-sm">Auto</span>
                    </button>

                    <!-- Theme dropdown (anchored popover) -->
                    <div id="themeMenu" role="menu" aria-hidden="true"
                        class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 border rounded-md py-1">
                        <button data-theme-option="auto" role="menuitem" type="button"
                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                            <span class="text-lg">🌓</span>
                            <span>Auto</span>
                        </button>
                        <button data-theme-option="dark" role="menuitem" type="button"
                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                            <span class="text-lg">🌙</span>
                            <span>Dark</span>
                        </button>
                        <button data-theme-option="light" role="menuitem" type="button"
                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                            <span class="text-lg">☀️</span>
                            <span>Light</span>
                        </button>
                    </div>
                </div>

                <div class="relative">
                    <button id="profileMenuButton" type="button" aria-expanded="false" aria-controls="profileMenu"
                        class="flex items-center gap-2 p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <img src="{{ class_exists(\Illuminate\Support\Facades\Vite::class) ? Vite::asset('resources/img/logo.svg') : asset('vendor/Dotclang/auth-package/img/logo.svg') }}"
                            alt="avatar" class="h-8 w-8 rounded-full" />
                        <span class="hidden sm:inline text-sm">Account</span>
                    </button>
                    <!-- Simple dropdown -->
                    <div id="profileMenu" role="menu" aria-hidden="true"
                        class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border rounded-md py-1">
                        <a href="{{ route('profile') }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toggle behaviors are provided by compiled JS: resources/js/toggles.js --}}
    @if (class_exists(\Illuminate\Support\Facades\Vite::class))
        @vite(['resources/js/app.js'])
    @else
        <script src="{{ asset('vendor/Dotclang/auth-package/js/app.js') }}" defer></script>
    @endif
</header>
