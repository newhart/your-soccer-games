<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompetitionType extends Model
{
    use HasFactory;

    public $timestamps = false;

    // assingment property
    protected $fillable = [
        'id',
        'name',
    ];


    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
}
