<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $guarded = []; 
    use HasFactory;

    public function players() : BelongsToMany {
        return $this->belongsToMany(Player::class); 
    }
}
