<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'attributes';
    protected $guarded = [];

    public const VIDA = 1;
    public const MANA = 2;
    public const ATAQUE = 3;
    public const DEFESA = 4;

    public function attributesPoints(): HasMany
    {
        return $this->hasMany(AttributePoint::class);
    }

    public function player(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'attribute_points', 'attribute_id', 'player_id');
    }

    public static function hasCurrentPoints($attributeId)
    {
        return in_array($attributeId, [self::VIDA, self::MANA]);
    }
}
