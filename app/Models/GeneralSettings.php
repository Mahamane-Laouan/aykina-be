<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'general_settings';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'website',
        'country',
        'state',
        'city',
        'zipcode',
        'address',
        'description',
        'created_at',
        'updated_at',
    ];
}
