<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteProduct extends Component
{
    public function __construct(
        public string $url,
        public string $name = 'Item',
        public string $message = 'Are you sure you want to delete this item?',
        public bool $iconOnly = false,
        public string $variant = 'default',
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.delete-product');
    }
}
