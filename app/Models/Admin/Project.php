<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'admin_projects';

    protected $fillable = [
        'title',
        'description',
        'repository_link',
        'link',
        'image',
        'category',
        'status',
    ];
}
