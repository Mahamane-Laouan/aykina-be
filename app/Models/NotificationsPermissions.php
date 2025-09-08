<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsPermissions extends Model
{
  use HasFactory;
  protected $table = 'notification_permissions';
  protected $fillable = [
    'id',
    'name',
    'label',
    'description',
    'type',
    'to',
    'bcc',
    'cc',
    'status',
    'channels',
    'created_by',
    'updated_by',
    'deleted_by',
    'role_type',
    'title',
  ];
}
