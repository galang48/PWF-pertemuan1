<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditProduct extends Component
{
    public function __construct(
        public string $url,
        public string $name = 'Item',
        public bool $iconOnly = false,
        public string $variant = 'default',
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.edit-product');
    }
}
