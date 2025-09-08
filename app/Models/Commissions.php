<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commissions extends Model
{
  use HasFactory;
  protected $table = 'commissions';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'people_id',
    'value',
    'type',
    'created_at',
  ];
}
