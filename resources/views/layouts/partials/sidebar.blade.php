<aside id="sidebar"
    class="w-64 bg-white dark:bg-gray-800 border-r dark:border-gray-700 h-screen sticky top-0 transform -translate-x-0 transition-transform duration-200">
    <div class="p-4 h-full flex flex-col">
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ class_exists(\Illuminate\Support\Facades\Vite::class) ? Vite::asset('resources/img/logo.svg') : asset('vendor/Dotclang/auth-package/img/logo.svg') }}" alt="Logo" class="h-10 w-10" />
            <div>
                <div class="font-semibold">AuthPackage</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">dotclang</div>
            </div>
        </div>

        <nav class="space-y-1 mt-4 flex-1">
            <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">Dashboard</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">Logout</button>
            </form>
        </nav>
    </div>
</aside>
