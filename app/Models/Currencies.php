<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    protected $table = 'currencies';
    protected $guard = 'admin';
    protected $fillable = [
        'id',
        'currency',
        'name',
        'created_at',
        'updated_at',
    ];
}
