<header class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-4">
                <button id="sidebarToggle" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
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
                <button id="darkModeToggle" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m8.66-9H21M3 12H4.34M17.66 6.34l.7.7M6.64 17.36l.7.7M17.66 17.66l.7-.7M6.64 6.64l.7-.7">
                        </path>
                    </svg>
                </button>

                <div class="relative">
                    <button id="profileMenuButton"
                        class="flex items-center gap-2 p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                        <img src="{{ asset('img/logo.svg') }}" alt="avatar" class="h-8 w-8 rounded-full" />
                        <span class="hidden sm:inline text-sm">Account</span>
                    </button>
                    <!-- Simple dropdown -->
                    <div id="profileMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border rounded-md py-1">
                        <a href="#"
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
