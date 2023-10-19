<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharingUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'sharing_id',
        'user_id',
        'sharing_ratio',
        'status',
    ];
}
