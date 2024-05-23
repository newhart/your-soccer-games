<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompetitionGame extends Model
{
    use HasFactory;

    public $timestamps = false;

    // filable property 
    protected $fillable = [
        'id',
        'season_id',
        'duration_game',
        'game_date',
        'game_hour',
        'attendace',
        'by_game',
        'shootout',
        'liver',
        'num_match',
        'type_match',
        'shadown_game',
        'lineup',
        'video',
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class)->withPivot('goal_for', 'home');
    }

    public function club_resluts(): HasMany
    {
        return $this->hasMany(ClubResult::class);
    }
}
