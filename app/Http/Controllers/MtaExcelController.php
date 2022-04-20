<?php

namespace App\Http\Controllers;

use App\Exports\ExportExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use \App\Imports\ExcelImportToArray;
use \App\Imports\ExcelMultipleSheet;

class MtaExcelController extends Controller
{
    public function exportMtaExcel(Request $request)
    {
        // dari query
        $data_array = [
            [
                'part_id' => 'Part1',
                'part_name' => 'Nama Part'
            ]
        ]; 

        return Excel::download(new ExportExcel($data_array), 'nama_excel_filenya.xlsx');
    }

    public function importMtaExcel(Request $request)
    {
        $import = new ExcelImportToArray();
        $data = Excel::toArray($import , $request->file('attachment'));
        $type = $request->type;

        // looping data arraynya
        foreach($data as $row) {
            foreach ($row as $part) {
                if($type == 'insertmta') {
                    DB::connection('mta')->table('mcostcenter')->insert([
                        'strsect' => $part['cost_center'],
                        'strsectdesc' => $part['section'],
                        'strdept' => $part['cost_center_dept'],
                        'strdeptdesc' => $part['departement'],
                        'strdiscontinue' => $part['state_discontinue'],
                        'ipriority' => $part['priority'],
                    ]);
                } else if($type == 'updatemta') {
                    DB::connection('mta')->table('mcostcenter')
                        ->where('strsect', $part['cost_center'])
                        ->update([
                            // set value yg diupdate
                            'strdept' => $part['departement'],
                            'strdiscontinue' => $part['state_discontinue'],
                        ]);
                }
            }
        }

        return response()->json(['message' => 'Import file successfully.'], 200);
    }
}
