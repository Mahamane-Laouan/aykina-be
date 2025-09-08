<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetup extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'theme_setup';

    protected $fillable = [
        'id',
        'logo',
        'footer_logo',
        'fav_icon',
        'color_code',
        'created_at',
        'updated_at',
    ];
}
