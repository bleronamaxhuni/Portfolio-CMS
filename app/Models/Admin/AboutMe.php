<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    protected $table = 'admin_about_me';

    protected $fillable = [
        'bio',
        'profile_image',
        'profile_image_data',
        'profile_image_mime',
        'resume_link',
    ];
}
