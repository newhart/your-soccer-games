<?php

namespace App\Models;

use App\Models\Commandes;
use App\Models\TypeMatch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $guarded  = [];
    public function type_match(): BelongsTo
    {
        return $this->belongsTo(TypeMatch::class);
    }
    public function commande(): HasOne
    {
        return $this->hasOne(Commandes::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }

    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commandes::class);
    }

    public function moment(): BelongsTo
    {
        return $this->belongsTo(Moment::class);
    }

    public function olderPlayer(): HasOne
    {
        return $this->hasOne(OlderPlayer::class);
    }
}
