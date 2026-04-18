@php
    $buttonClasses = $variant === 'detail'
        ? 'inline-flex items-center gap-2 rounded-xl border border-amber-500/70 px-5 py-3 text-sm font-semibold text-amber-300 transition hover:bg-amber-500/10 hover:text-amber-200'
        : 'inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg border border-amber-300 dark:border-amber-600 text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition';
    $label = $variant === 'detail' ? 'Edit' : "Edit {$name}";
@endphp

@if ($iconOnly)
    <a href="{{ $url }}" title="Edit {{ $name }}" aria-label="Edit {{ $name }}"
        {{ $attributes->merge(['class' => 'p-1.5 rounded-md text-gray-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </a>
@else
    <a href="{{ $url }}" {{ $attributes->merge(['class' => $buttonClasses]) }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        {{ $label }}
    </a>
@endif
