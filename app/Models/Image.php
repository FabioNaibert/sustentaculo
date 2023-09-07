<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Image extends Model
{
    use HasFactory;

    public function weapon(): HasOne
    {
        return $this->hasOne(Weapon::class);
    }

    public function history(): HasOne
    {
        return $this->hasOne(History::class);
    }

    public function chapter(): HasOne
    {
        return $this->hasOne(Chapter::class);
    }
}
