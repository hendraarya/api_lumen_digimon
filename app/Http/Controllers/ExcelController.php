<?php

namespace App\Http\Controllers;

use App\Exports\ExportExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function exportExcel(Request $request)
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

    public function importExcel(Request $request)
    {
        $data = Excel::toArray(new \App\Imports\ExcelImportToArray, $request->file('attachment'));
        $type = $request->type;

        // looping data arraynya
        foreach($data as $row) {
            foreach ($row as $part) {
                if($type == '1') {
                    DB::table('parts')->insert([
                        'part_id' => $part['part_id'],
                        'part_name' => $part['part_name'],
                        'type' => $part['type'],
                        'brand' => $part['brand'],
                    ]);
                } else {
                    DB::table('parts')
                        ->where('part_id', $part['part_id'])
                        ->update([
                            // set value yg diupdate
                            'part_name' => 'UPDATEAN PART',
                            'type' => 'UPDATEAN PART',
                            'brand' => 'UPDATEAN PART',
                        ]);
                }
            }
        }

        return response()->json(['message' => 'Import file successfully.'], 200);
    }
}
