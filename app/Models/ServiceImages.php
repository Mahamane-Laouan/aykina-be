<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceImages extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'service_images';

    protected $fillable = [
        'id',
        'service_id',
        'service_images',
        'created_at',
        'updated_at',
    ];
}
