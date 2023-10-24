<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Weapon extends Model
{
    use HasFactory;

    protected $table = 'weapons';
    protected $guarded = [];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function history(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attributesPoints(): HasMany
    {
        return $this->hasMany(AttributePoint::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_points', 'weapon_id', 'attribute_id');
    }
}
