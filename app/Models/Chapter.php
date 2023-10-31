<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chapter extends Model
{
    use HasFactory;

    protected $table = 'chapters';
    protected $guarded = [];
    // protected $appends = ['has_next', 'has_multi_routes', 'possible_routes'];


    public function history(): BelongsTo
    {
        return $this->belongsTo(History::class);
    }

    public function previous(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function nextChapters(): HasMany
    {
        return $this->hasMany(Chapter::class, 'previous_id', 'id');
    }

    // public function image(): BelongsTo
    // {
    //     return $this->belongsTo(Image::class);
    // }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'chapters_images', 'chapter_id', 'image_id');
    }

    public function sounds(): BelongsToMany
    {
        return $this->belongsToMany(Sound::class, 'chapters_sounds', 'chapter_id', 'sound_id');
    }

    public function getHasNextAttribute()
    {
        return $this->nextChapters()->count() > 0;
    }

    public function getHasMultiRoutesAttribute()
    {
        return $this->nextChapters()->count() > 1;
    }

    public function getPossibleRoutesAttribute()
    {
        return $this->nextChapters()->get(['id', 'title']);
    }
}
