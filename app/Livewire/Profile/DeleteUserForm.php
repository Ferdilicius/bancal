<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Livewire\Component;

class DeleteUserForm extends Component
{
    public $confirmingUserDeletion = false;
    public $password = '';

    public function confirmUserDeletion()
    {
        $this->resetErrorBag();
        $this->confirmingUserDeletion = true;
    }

    public function deleteUser(DeletesUsers $deleter)
    {
        $user = auth()->user();

        // Si tiene contraseña, validarla
        if ($user->password) {
            $this->validate([
                'password' => ['required', 'string'],
            ]);
        }

        $deleter->delete($user, ['password' => $this->password]);
        return redirect()->route('home'); // Cambia la ruta si necesitas
    }

    public function render()
    {
        return view('livewire.profile.delete-user-form');
    }
}
