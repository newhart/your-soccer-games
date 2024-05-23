<?php

namespace App\Models;

use App\Models\Product;
use App\Models\PrixMatch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeMatch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function prix_match(): HasOne
    {
        return $this->hasOne(PrixMatch::class);
    }
    public function matchs(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
