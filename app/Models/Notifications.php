<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
  protected $table = 'admin_notifications';
  protected $guard = 'admin';
  protected $fillable = [
    'title',
    'message',
    'created_at',
  ];

  // public function users()
  // {
  //   return $this->hasMany(User::class, 'user_id', 'id');
  // }
}
