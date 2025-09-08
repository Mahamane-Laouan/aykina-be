<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model
{
  use HasFactory;
  protected $guard = 'admin';
  protected $table = 'terms_conditions';

  protected $fillable = [
    'id',
    'image',
    'created_at',
    'updated_at',
  ];
}
