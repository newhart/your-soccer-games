<?php

namespace App\Models;

use App\Models\TypeMatch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrixMatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'prix',
        'type_match_id',
    ];
    public function type_match(): BelongsTo
    {
        return $this->belongsTo(TypeMatch::class);
    }
}
