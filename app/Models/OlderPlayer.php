<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class OlderPlayer extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'whatsapp', 'langue', 'photo', 'status', 'token', 'product_id'];

    public function imageUrl(): string
    {
        return Storage::disk('public')->url($this->photo);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
