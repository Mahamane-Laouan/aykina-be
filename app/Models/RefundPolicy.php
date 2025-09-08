<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundPolicy extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'refund_policy';

    protected $fillable = [
        'id',
        'text',
        'created_at',
        'updated_at',
    ];
}
