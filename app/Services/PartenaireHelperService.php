<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class PartenaireHelperService
 * @package App\Services
 */
class PartenaireHelperService
{
    public static function display(string $name, int $key){
        $names = []; 
        if (array_key_exists($key,$names) && !in_array($name , $names[$key])) {
            $names[$key][] = $name; 
        }
        return implode(',', $names[$key]) ;
    }

    public static function test(Collection $products){
       $names = []; 
       foreach ($products as $product) {
        $name = $product->product?->user?->name === 'Administrateur' ? 'Your soccer games' :  $product->product?->user?->name; 
        if (!in_array($name , $names)) {
            $names[] = $name; 
        }
       }
       return implode(',', $names); 
    }
}
