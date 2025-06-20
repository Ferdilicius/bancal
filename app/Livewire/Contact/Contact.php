<?php

namespace App\Livewire\Contact;

use Livewire\Component;
use App\Models\Message;
use App\Models\MessageType;

class Contact extends Component
{
    // public $user = auth()->user();
    public $email;
    public $message_type_id;
    public $message;
    public $messageTypes = [];

    public $messages = [];

    protected $rules = [
        'email' => 'nullable|email|max:255',
        'message_type_id' => 'required|exists:message_types,id',
        'message' => 'required|string|min:20',
    ];

    public function mount()
    {
        $this->messageTypes = MessageType::all();
        // $this->loadMessages();
    }

    public function enviarConsulta()
    {
        // dd($this->message_type_id);
        $this->validate();
        // Guardar el mensaje en la base de datos
        Message::create([
            'email' => auth()->check() ? null : $this->email,
            'message' => $this->message,
            'message_type_id' => $this->message_type_id,
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);

        session()->flash('success', '¡Tu consulta ha sido enviada!');

        $this->reset(['email', 'message_type_id', 'message']);
        // $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.contact')->layout('layouts.app');
    }

    // public function loadMessages()
    // {
    //     // Si quieres solo los del usuario autenticado:
    //     $this->messages = Message::where('user_id', auth()->id())->latest()->take(10)->get();
    //     // O para todos los mensajes: $this->messages = Message::latest()->take(10)->get();
    // }
}
