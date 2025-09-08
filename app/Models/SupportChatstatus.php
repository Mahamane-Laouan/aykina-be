<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportChatstatus extends Model
{
  use HasFactory;

  protected $table = 'support_chat_status'; // Replace 'table_name' with the name of your database table

  protected $fillable = [
    'from_user',
    'to_user',
    'order_number',
    'status',

    // Add more columns as needed
  ];
}
