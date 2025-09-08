<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProof extends Model
{
  use HasFactory;
  protected $table = 'service_proof';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'service_name',
    'handyman_id',
    'notes',
    'image',
    'booking_id',
    'user_id',
    'rev_star',
    'rev_text',
    'created_at',

  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'handyman_id', 'id'); // Adjust column names if necessary
  }

}
