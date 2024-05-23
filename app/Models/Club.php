<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    use HasFactory;
    // assingment property
    protected $fillable = [
        'id',
        'name',
        'full_name',
        'short_name',
        'national_team',
        'zip_code',
        'address',
        'fundation_at',
        'end_at',
        'website',
        'first_color',
        'seconds_color',
        'city_id'
    ];


    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot('arrival_at', 'leaving_at');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(VariationClub::class);
    }

    public function competition_games(): BelongsToMany
    {
        return $this->belongsToMany(CompetitionGame::class)->withPivot('goal_for', 'home');
    }

    public function club_results(): HasMany
    {
        return $this->hasMany(ClubResult::class);
    }
}
