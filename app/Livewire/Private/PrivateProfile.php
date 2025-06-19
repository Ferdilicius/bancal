<?php

namespace App\Livewire\Private;

use Livewire\Component;

class PrivateProfile extends Component
{
    public function render()
    {
        return view('livewire.private.private-profile')->layout('layouts.app');
    }
}
