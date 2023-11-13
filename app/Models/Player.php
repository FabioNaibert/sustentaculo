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

    public const VIDA = 1;
    public const MANA = 2;
    public const ATAQUE = 3;
    public const DEFESA = 4;

    public function history(): BelongsTo
    {
        return $this->belongsTo(History::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attributesPoints(): HasMany
    {
        return $this->hasMany(AttributePoint::class);
    }

    public function weapons(): HasMany
    {
        return $this->hasMany(Weapon::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_points', 'player_id', 'attribute_id');
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'players_images', 'player_id', 'image_id');
    }

    public function getMasterIdAttribute()
    {
        return $this->history()->get(['master_id'])->first()->master_id;
    }

    public function getWeaponEquipedAttribute()
    {
        return $this->weapons()->where('equiped', true)->first();
    }

    public function getAttributesCalcAttribute()
    {
        return $this->attributesPoints()->get();
    }
}
