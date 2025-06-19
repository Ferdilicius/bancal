<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;
use \Illuminate\Support\Facades\Hash;
use \Illuminate\Validation\ValidationException;

class DeleteUser implements DeletesUsers
{
    public function delete($user, array $input): void
    {
        // Validate password only if the user has one (not OAuth)
        if ($user->password && (!isset($input['password']) || !Hash::check($input['password'], $user->password))) {
            throw ValidationException::withMessages([
                'password' => __('La contraseña proporcionada es incorrecta.'),
            ]);
        }

        // Delete profile photo if exists
        $user->deleteProfilePhoto();

        // Delete API tokens
        $user->tokens->each->delete();

        // Delete the account
        $user->delete();
    }
}
