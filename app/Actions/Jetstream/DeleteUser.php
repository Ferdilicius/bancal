<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DeleteUser implements DeletesUsers
{
    public function delete($user, array $input): void
    {
        // Solo validar si el usuario tiene contraseña
        if ($user->password && (!isset($input['password']) || !Hash::check($input['password'], $user->password))) {
            throw ValidationException::withMessages([
                'password' => __('La contraseña proporcionada es incorrecta.'),
            ]);
        }

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
