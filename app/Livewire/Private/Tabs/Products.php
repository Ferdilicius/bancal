<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Products extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Auth::user()->products()->get();
    }

    public function render()
    {
        return view('livewire.private.tabs.products');
    }
}
