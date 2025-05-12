<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MyAccount extends Component
{
    public $user;
    public $products;

    public function mount()
    {
        $this->user = Auth::user();
        $this->products = $this->user->products()->get();
    }

    public function render()
    {
        return view('livewire.my-account')->layout('layouts.app');
    }
}
