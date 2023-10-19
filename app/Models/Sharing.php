<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sharing extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(SharingUser::class, 'user_id', 'id');
    }

    public function records()
    {
        return $this->hasMany(SharingRecord::class);
    }
}
