<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'admin_messages';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }
}
