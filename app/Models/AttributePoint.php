<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributePoint extends Pivot
{
    use HasFactory;

    protected $table = 'attribute_points';
    protected $guarded = [];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function weapon(): BelongsTo
    {
        return $this->belongsTo(Weapon::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
