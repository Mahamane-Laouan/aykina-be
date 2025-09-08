<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
  use HasFactory;

  protected $table = 'support_chat'; // Replace 'table_name' with the name of your database table

  protected $fillable = [
    'from_user',
    'to_user',
    'order_number',
    'message',
    'type',
    'url',
    'status',
    'subject',
    'admin_message',
    'created_at',
    'updated_at',
    // Add more columns as needed
  ];
}
