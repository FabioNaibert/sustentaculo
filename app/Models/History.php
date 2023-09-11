<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';
    protected $guarded = [];

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function master(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }


    public function firstChapter() {
        return $this->chapters()->one()->ofMany('id', 'min');
    }
}
