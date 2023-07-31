<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasFactory;

    public const TYPE_ADD = 1;

    public const TYPE_SUB = -1;

    public const TYPE_ALL = 0;

    protected $fillable = [
        'reciprocal_name',
        'user_id',
        'type',
        'category_id',
        'amount',
        'transaction_at',
        'remarks',
    ];

    protected $casts = [
        'transaction_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
