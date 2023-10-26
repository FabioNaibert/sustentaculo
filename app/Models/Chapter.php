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
        return $this->hasMany(Chapter::class);
    }

    // public function image(): BelongsTo
    // {
    //     return $this->belongsTo(Image::class);
    // }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'chapters_images', 'chapter_id', 'image_id');
    }
}
