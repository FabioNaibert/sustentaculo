<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sound extends Model
{
    use HasFactory;

    protected $table = 'sounds';
    protected $guarded = [];

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class, 'chapters_sounds', 'sound_id', 'chapter_id');
    }
}
