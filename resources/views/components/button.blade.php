<button
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500']) }}>
    {{ $slot }}
</button>
