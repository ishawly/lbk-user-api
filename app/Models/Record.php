<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    public const TYPE_ADD = 1;

    public const TYPE_SUB = -1;

    public const TYPE_ALL = 0;
}
