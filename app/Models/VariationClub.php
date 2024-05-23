<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariationClub extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'variant_name',
        'short_variant_name',
        'club_id'
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
}
