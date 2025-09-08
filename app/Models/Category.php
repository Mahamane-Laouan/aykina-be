<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'categories';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'c_name',
    'c_name_a',
    'icon',
    'img',
    'description',
    'is_features',
    'status',
  ];
}
