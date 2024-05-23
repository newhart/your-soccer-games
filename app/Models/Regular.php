<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regular extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'player_id');
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class, 'season_id');
    }
}
