@php
    $buttonClasses = $variant === 'detail'
        ? 'inline-flex items-center gap-2 rounded-xl border border-red-500/70 px-5 py-3 text-sm font-semibold text-red-300 transition hover:bg-red-500/10 hover:text-red-200'
        : 'inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg border border-red-300 dark:border-red-600 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition';
    $label = $variant === 'detail' ? 'Delete' : "Delete {$name}";
@endphp

<form action="{{ $url }}" method="POST" onsubmit="return confirm(@js($message))" {{ $attributes->only('class') }}>
    @csrf
    @method('DELETE')

    @if ($iconOnly)
        <button type="submit" title="Delete {{ $name }}" aria-label="Delete {{ $name }}"
            class="p-1.5 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4h6v3" />
            </svg>
        </button>
    @else
        <button type="submit" class="{{ $buttonClasses }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4h6v3" />
            </svg>
            {{ $label }}
        </button>
    @endif
</form>
