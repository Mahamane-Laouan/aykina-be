<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginStatus extends Model
{
  use HasFactory;
  protected $table = "user_login_status";
  protected $primary_key = "id";
  protected $guard = 'admin';

  protected $fillable = [
    'text',
    'status',
    'handyman_status',
  ];
}
