<?php

namespace App\Services;

use Faker\Generator;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageService
{
    public function generatePicture(string $item, string $type)
    {
        $filename = (new Generator())->randomNumber(7, true) . '.png';
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $item));
        // $file = Image::make($file)->encode('webp');
        Storage::disk($type)->put($filename, $file);
        return asset('img/' . $type . '/' . $filename);
    }
}
