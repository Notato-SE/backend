<?php

namespace App\Exports;

use App\Models\Randomizer\Randomizer;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RandomizerExport implements FromArray, WithMapping, WithHeadings
{
    use Exportable;
    public function __construct(int $randomId, string $heading, array $randomVal)
    {
        $this->randomId = $randomId;
        $this->heading = $heading;
        $this->randomVal = $randomVal;
    }

    public function array(): array
    {
        return $this->randomVal;
    }
    public function map($result): array
    {
        return [$result];
    }
    public function headings(): array
    {
        return [
           $this->heading
        ];
    }
}
