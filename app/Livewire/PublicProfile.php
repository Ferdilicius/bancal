<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class PublicProfile extends Component
{
    public $user;
    public $products;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->products = $user->products;
    }

    public function render()
    {
        return view('livewire.public-profile')->layout('layouts.app');
    }
}
