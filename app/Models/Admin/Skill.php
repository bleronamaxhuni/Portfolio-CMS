<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'admin_skills';
    
    protected $fillable = [
        'name',
        'proficiency_level',
        'icon',
    ];
}
