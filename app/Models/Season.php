<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;
    public $timestamps = false;
    // assingment property
    protected $fillable = [
        'id',
        'competition_season_name',
        'start_at',
        'end_at',
        'priority',
        'division_number',
        'season',
        'competition_id',
        'competition_type_id'
    ];


    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function competition_types(): HasMany
    {
        return $this->hasMany(CompetitionType::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }

    public function competition_games(): HasMany
    {
        return $this->hasMany(CompetitionGame::class);
    }
}
