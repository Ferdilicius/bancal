<?php

namespace App\Livewire\Contact;

use Livewire\Component;

class Contact extends Component
{
    public $nombre;
    public $email;
    public $tipo;
    public $prioridad = 'low';
    public $mensaje;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'tipo' => 'required|string',
        'prioridad' => 'nullable|string',
        'mensaje' => 'required|string|min:20',
    ];

    public function enviarConsulta()
    {
        $this->validate();

        // Aquí puedes guardar el mensaje o enviar un correo, etc.
        // Por ejemplo:
        // Message::create([...]);

        session()->flash('success', '¡Tu consulta ha sido enviada!');
        $this->reset(['nombre', 'email', 'tipo', 'prioridad', 'mensaje']);
    }

    public function render()
    {
        return view('livewire.contact')->layout('layouts.app');
    }
}
