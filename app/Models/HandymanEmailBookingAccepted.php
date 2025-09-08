<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandymanEmailBookingAccepted extends Model
{
    use HasFactory;
    protected $table = 'email_handyman_accept_booking';
    protected $guard = 'admin';

    protected $fillable = [
        'id',
        'logo',
        'title',
        'body',
        'section_text',
        'privacy_policy',
        'refund_policy',
        'cancellation_policy',
        'contact_us',
        'twitter',
        'linkedIn',
        'instagram',
        'facebook',
        'copyright_content',
        'get_email',
        'created_at',
        'updated_at',
    ];
}
