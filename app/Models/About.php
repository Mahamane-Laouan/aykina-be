<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'about';

    protected $fillable = [
        'id',
        'text',
        'created_at',
        'updated_at',
    ];
}
