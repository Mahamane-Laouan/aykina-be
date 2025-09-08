<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetup extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'site_setup';

    protected $fillable = [
        'id',
        'distance',
        'distance_type',
        'default_currency',
        'copyright_text',
        'android_url',
        'android_provider_url',
        'ios_url',
        'ios_provider_url',
        'purchase_code',
        'created_at',
        'updated_at',
    ];
}
