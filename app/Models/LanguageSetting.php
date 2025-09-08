<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageSetting extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'Language_settings';
    protected $primaryKey = 'setting_id';

    protected $fillable = ['setting_id', 'key', 'createdAt', 'updatedAt', 'English', 'Gujarati', 'Arabic', 'French', 'Russian', 'Hindi'];
}
