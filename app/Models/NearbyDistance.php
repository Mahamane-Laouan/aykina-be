<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearbyDistance extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'nearby_distance';

    protected $fillable = [
        'id',
        'distance',
        'distance_type',
        'created_at',
        'updated_at',
    ];
}
