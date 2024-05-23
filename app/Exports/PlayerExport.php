<?php

namespace App\Exports;

use App\Models\Player;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PlayerExport implements FromArray,  WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function array() : array
    {
        return $this->data ; 
    }

    public function headings(): array
    {
        return [
            'Nom', 'Prenom', "Dates d'anniversaire",
        ];
    }
}
