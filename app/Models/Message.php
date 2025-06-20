<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
        'message_type_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messageType()
    {
        return $this->belongsTo(MessageType::class, 'message_type_id');
    }
}
