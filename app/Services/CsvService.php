<?php

namespace App\Services;

use League\Csv\Reader;


/**
 * Class CsvService
 * @package App\Services
 */
class CsvService
{

    public static  function readCSV(string $path)
    {
        $csv = Reader::createFromPath(storage_path($path), 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        $csv->setEnclosure('"');
        return $csv;
    }

    public static  function test(string $path)
    {
        $csv = Reader::createFromPath(storage_path($path), 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        $csv->setEnclosure('"');
        return $csv;
    }
}
