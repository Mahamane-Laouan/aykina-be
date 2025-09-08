<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultImage extends Model
{
    protected $table = 'default_image';
    protected $guard = 'admin';
    protected $fillable = [
        'id',
        'people_id',
        'role',
        'image',
        'created_at',
        'updated_at',
    ];
}
