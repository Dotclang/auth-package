<label class="block">
    @if ($label)
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
    @endif
    <input name="{{ $name ?? $attributes->get('name') }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600']) }} />

    @if ($errors && ($err = $errors->first($name ?? $attributes->get('name'))))
        <p class="mt-1 text-sm text-red-600">{{ $err }}</p>
    @endif
</label>
