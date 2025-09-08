<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'social_media';

    protected $fillable = [
        'id',
        'facebook_link',
        'whatsapp_link',
        'instagram_link',
        'twitter_link',
        'youtube_link',
        'linkdln_link',
        'created_at',
        'updated_at',
    ];
}
