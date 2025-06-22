<?php

namespace App\Livewire\Order;

use Livewire\Component;

class Success extends Component
{
    public function render()
    {
        return view('livewire.order.success')->layout('layouts.app');
    }
}
