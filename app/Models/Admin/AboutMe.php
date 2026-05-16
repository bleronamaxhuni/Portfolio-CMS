<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutMe extends Model
{
    protected $table = 'admin_about_me';

    protected $fillable = [
        'bio',
        'profile_image',
        'profile_img',
        'profile_image_data',
        'profile_image_mime',
        'resume_link',
    ];

    protected $appends = [
        'profile_img_url',
    ];

    protected $hidden = [
        'profile_image_data',
    ];

    public function getProfileImgUrlAttribute(): ?string
    {
        if ($this->profile_image_data && $this->profile_image_mime) {
            return 'data:'.$this->profile_image_mime.';base64,'.$this->profile_image_data;
        }

        $path = $this->profile_img ?? $this->profile_image;

        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'data:')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
