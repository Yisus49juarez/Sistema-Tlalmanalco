<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatSoporte extends Model
{
    protected $table = 'chats_soporte';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'mensaje',
        'leido',
    ];

    protected function casts(): array
    {
        return [
            'leido' => 'boolean',
        ];
    }

    public function remitente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}