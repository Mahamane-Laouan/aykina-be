<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageStatus extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'Language_statuses';
    protected $primaryKey = 'status_id';

    protected $fillable = ['status_id', 'language', 'language_alignment', 'country', 'status', 'default_status', 'createdAt', 'updatedAt'];
}
