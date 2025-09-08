<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandymanReview extends Model
{
  use HasFactory;

  protected $table = "handyman_review";
  protected $primary_key = "id";
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'handyman_id',
    'service_id',
    'provider_id',
    'user_id',
    'text',
    'star_count',
    'booking_id',
    'created_at',
  ];


    public function handyman()
    {
        return $this->belongsTo(User::class, 'handyman_id');
    }


  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
