<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $guarded = [];

    public function weapon(): HasOne
    {
        return $this->hasOne(Weapon::class);
    }

    public function history(): HasOne
    {
        return $this->hasOne(History::class);
    }

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class, 'chapters_images', 'image_id', 'chapter_id');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class, 'players_images', 'image_id', 'player_id');
    }
}
