<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileUrl extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'mobile_url';

    protected $fillable = [
        'id',
        'android_url',
        'android_provider_url',
        'ios_url',
        'ios_provider_url',
        'created_at',
        'updated_at',
    ];
}
