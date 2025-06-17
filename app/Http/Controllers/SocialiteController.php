<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        // Redirige al proveedor (Google, Facebook, etc.)
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            // IMPORTANTE: stateless() previene el error InvalidStateException
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            // En producción deberías loguear el error ($e->getMessage()) para depurar
            return redirect()->route('login')->withErrors([
                'msg' => 'Error al iniciar sesión con ' . $provider
            ]);
        }

        // Verifica si ya existe un usuario con ese email
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            // Si no existe, se crea un nuevo usuario
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Usuario',
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)), // Contraseña aleatoria
                'provider_id' => $socialUser->getId(),
                'provider_name' => $provider,
                'email_verified_at' => now(), // Se marca como verificado
            ]);
        }

        // Inicia sesión al usuario
        Auth::login($user, true); // true = recordar sesión

        // Redirige a la zona privada
        return redirect()->route('private-profile');
    }
}
