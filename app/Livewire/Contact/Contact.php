<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use App\Models\MessageType;

class Contact extends Component
{
    public $name;
    public $email;
    public $message;
    public $messageTypes = [];

    // public function mount()
    // {
    //     $this->messageTypes = MessageType::all();

    //     $this->reset(['name', 'email', 'message']);
    // }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'mensaje' => 'required|string|min:20',
    ];

    public function enviarConsulta()
    {
        $this->validate();
        $this->reset(['name', 'email', 'mensaje']);
    }

    public function render()
    {
        return view('livewire.contact')->layout('layouts.app');
    }
}
