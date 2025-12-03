<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Type extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    // Subtype (actual stored type_id)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', 0);
    }
}
