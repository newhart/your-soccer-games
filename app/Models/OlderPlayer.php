<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OlderPlayer extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'whatsapp', 'langue', 'photo', 'status', 'token', 'name'];

    public function imageUrl(): string
    {
        return Storage::disk('public')->url($this->photo);
    }
}
