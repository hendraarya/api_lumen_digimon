<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            'Update MTA' => new FirstSheetImport(),
            'Insert MTA' => new SecondSheetImport(),
        ];
    }
}
