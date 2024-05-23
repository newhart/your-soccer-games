<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    use HasFactory;

    // assingment property
    protected $fillable = [
        'id',
        'name',
        'country_id',
    ];


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function season(): HasMany
    {
        return $this->hasMany(Season::class);
    }
}
