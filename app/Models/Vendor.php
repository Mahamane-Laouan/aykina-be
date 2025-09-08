<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
  protected $table = 'vendor';
  protected $guard = 'admin';
  protected $fillable = [
    'fname',
    'lname',
    'email',
    'uname',
    'password',
    'profile_image',
  ];
}
