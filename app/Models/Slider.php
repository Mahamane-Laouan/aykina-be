<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  protected $table = 'sliders';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'slider_name',
    'service_id',
    'slider_image',
    'slider_description',
    'status',
    'created_at',
    'updated_at',
  ];
}
