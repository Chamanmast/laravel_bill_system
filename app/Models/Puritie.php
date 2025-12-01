<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Puritie extends Model
{
    protected $guarded = [];

    public function type() :BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
