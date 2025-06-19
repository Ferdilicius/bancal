<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider_id',
        'provider_name',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function updateProfilePhoto(UploadedFile $photo): void
    {
        $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();

        // Guarda la imagen en la carpeta privada
        $photo->storeAs('private/profile-photos', $filename, 'local');

        // Elimina la anterior si existe
        if ($this->profile_photo_path && Storage::exists('private/profile-photos/' . $this->profile_photo_path)) {
            Storage::delete('private/profile-photos/' . $this->profile_photo_path);
        }

        // Guarda solo el nombre del archivo
        $this->forceFill([
            'profile_photo_path' => $filename,
        ])->save();
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo_path) {
            return route('profile.photo', ['filename' => $this->profile_photo_path]);
        }

        return $this->defaultProfilePhotoUrl();
    }
}
