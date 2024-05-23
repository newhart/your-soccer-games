<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    // assingment property
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'birth_date',
        'birth_place',
        'is_woman',
        'country_id',
        'image',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class)->withPivot('arrival_at', 'leaving_at');
    }

    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class);
    }

    public function club_results(): BelongsToMany
    {
        return $this->belongsToMany(ClubResult::class)->withPivot('substitude');
    }

    public function dates(): BelongsToMany
    {
        return $this->belongsToMany(Date::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
