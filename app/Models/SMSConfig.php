<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSConfig extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'sms_config';

    protected $fillable = [
        'id',
        'twilio_sid',
        'twilio_auth_token',
        'twilio_phone_number',
        'msg91_auth_key',
        'msg91_private_key',
        'created_at',
        'updated_at',
    ];
}
