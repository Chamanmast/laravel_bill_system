<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function types(): HasMany
    {
        return $this->hasmany(Type::class);
    }
    public function purities(): HasMany
    {
        return $this->hasmany(Puritie::class);
    }
    public function scopeActive($q)
    {
        return $q->where('status', 0);
    }
}
