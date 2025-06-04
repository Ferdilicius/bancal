<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Addresses extends Component
{
    public $addresses;

    public function mount()
    {
        $this->addresses = Auth::user()->addresses()->get();
    }

    public function render()
    {
        return view('livewire.private.tabs.addresses');
    }
}
