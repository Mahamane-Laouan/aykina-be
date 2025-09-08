<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firebase extends Model
{
  protected $table = 'firebase';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'firebase_key',
  ];
}
