<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  use HasFactory;

  protected $fillable = [
    'from_user',
    'to_user',
    'message',
    'url',
    'date',
    'time',
    'read_message',
    'type',

  ];
}
