<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';
    protected $guarded = [];

    public function history(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attributesPoints(): HasMany
    {
        return $this->hasMany(AttributePoint::class);
    }

    public function attributes(): BelongsToMany
    {
        // return $this->belongsToMany(Attribute::class)->using(AttributePoint::class);
        return $this->belongsToMany(Attribute::class, 'attribute_points', 'player_id', 'attribute_id');
    }
}
