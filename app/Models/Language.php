<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'language';
    protected $fillable = ['id', 'name', 'text', 'created_at', 'updated_at'];
}
