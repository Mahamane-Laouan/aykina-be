<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetup extends Model
{
    use HasFactory;
    protected $table = 'mail_setup';
    protected $guard = 'admin';

    protected $fillable = [
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_encryption',
        'mail_username',
        'mail_password',
        'mail_from',
        'type',
        'created_at',
    ];
}
