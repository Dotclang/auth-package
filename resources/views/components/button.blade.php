@php
    $variant = $variant ?? 'solid';
    $href = $href ?? '#';
    $label = $label ?? 'Button';
@endphp

@if ($variant === 'outline')
    <a href="{{ $href }}"
        class="inline-flex items-center justify-center px-4 py-2 border rounded-md text-sm font-medium text-indigo-600 border-indigo-600 dark:text-indigo-300 dark:border-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-700/20">{{ $label }}</a>
@else
    <a href="{{ $href }}"
        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">{{ $label }}</a>
@endif
