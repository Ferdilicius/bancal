<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
