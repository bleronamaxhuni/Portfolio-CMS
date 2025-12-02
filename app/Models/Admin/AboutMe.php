<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    protected $table = 'admin_about_me';

    protected $fillable = [
        'bio',
        'profile_image',
        'resume_link',
    ];
}
