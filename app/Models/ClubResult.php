<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClubResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'club_id',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function  players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class)->withPivot('substitude');
    }
    public function competition_game(): BelongsTo
    {
        return $this->belongsTo(CompetitionGame::class);
    }
}
