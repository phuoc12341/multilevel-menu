<?php

namespace App\Imports;

use App\Models\Child;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class ChildrenImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $listChild = $rows->splice('8');
        dd($rows->toArray());
        foreach ($listChild as $row)
        {
            Child::create([
                'number' => $row['0'],
                'holy_name' => $row['1'],
                'name' => $row['2'],
                'date_of_birth' => Date::excelToDateTimeObject($row['3']),
                'gender' => $row['4'],
                'phone' => $row['5'],
                'baptism' => $row['6'] == 'v' ? true : false,
                'holy_eucharist' => $row['7'] == 'v' ? true : false,
                'confirmation' => $row['8'] == 'v' ? true : false,
                'father' => $row['9'],
                'mother' => $row['10'],
                'address' => $row['11'],
                'diocese' => $row['12'],
            ]);
        }
    }
}
