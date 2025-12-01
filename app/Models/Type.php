<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{

    protected $guarded = [];
    public $timestamps = false;

    // Subtype (actual stored type_id)
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    // Parent Type (Gold / Silver etc.)
    public function parentType(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id')
            ->with('parent')
            ->first()
            ?->parent;
    }

    public function parent()
{
    return $this->belongsTo(Type::class, 'parent_id');
}
}
