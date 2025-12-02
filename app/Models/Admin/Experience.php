<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'admin_experiences';

    protected $fillable = [
        'title',
        'company',
        'start_date',
        'end_date',
        'description',
        'location',
    ];
}
