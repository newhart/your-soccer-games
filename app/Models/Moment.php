<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Moment extends Model
{
    use HasFactory;

    protected $fillable = [
        'current',
        'video',
    ];

    public function videoMatchs(): HasMany
    {
        return $this->hasMany(VideoMatch::class);
    }

    public function matchs(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
