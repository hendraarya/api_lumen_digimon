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

    public function importMtaExcelCostCenter(Request $request)
    {
        $import = new ExcelImportToArray();
        $data = Excel::toArray($import , $request->file('attachment'));
        $type = $request->type;

        // looping data arraynya
        foreach($data as $row) {
            foreach ($row as $part) {
                if($type == 'insertmtacostcenter') {
                    DB::connection('mta')->table('mcostcenter')->insert([
                        'strsect' => $part['cost_center'],
                        'strsectdesc' => $part['section'],
                        'strdept' => $part['cost_center_dept'],
                        'strdeptdesc' => $part['departement'],
                        'strdiscontinue' => $part['state_discontinue'],
                        'ipriority' => $part['priority'],
                    ]);
                } else if($type == 'updatemtacostcenter') {
                    DB::connection('mta')->table('mcostcenter')
                        ->where('strsect', $part['cost_center'])
                        ->update([
                            // set value yg diupdate
                            'strsectdesc' => $part['section_description'],
                            'strdept' => $part['departement'],
                            'strdiscontinue' => $part['state_discontinue'],
                        ]);
                }
            }
        }

        return response()->json(['message' => 'Import file successfully.'], 200);
    }

    public function importMtaExcelMachine(Request $request)
    {
        $import = new ExcelImportToArray();
        $data = Excel::toArray($import, $request->file('attachment'));
        $type = $request->type;

        foreach($data as $row)
        {
            foreach($row as $part)
            {
                if($type == 'insertmtamachine' )
                {
                    DB::connection('mta')->table('mmachine')->insert([
                        'machid' => $part['machine_id'],
                        'strdescription' => $part['machine_description'],
                        'machtypeid' => $part['machine_type_id'],
                        'sectionid' => $part['section_id'],
                        'wcid' => $part['work_center_id'],
                        'strwcgroup' => $part['work_center_group'],
                        'strwccode' => $part['work_center_code'],
                        'makerid' => $part['maker_id'],
                        'usermachid' => $part['user_machine_id'],
                        'strstatus' => $part['machine_status'],  // (Running,Handover,Standby,Transfer,Scrap)
                        'dtmfg' => $part['manufactured_date'],
                        'dtinstall' => $part['installation_date'],
                        'strmodel' => $part['machine_model'],
                        'strsn' => $part['machine_serial_number'],
                        'strsystem' => $part['control_system'],
                        'strcooling' => $part['cooling_system'],
                        'straircomp' => $part['compresed_air'],
                        'strcapacity' => $part['machine_capacity'],
                        'strvolt' => $part['power_supply'],
                        'iamper' => $part['main_breaker'],
                        'ihz' => $part['air_supply'],
                        'imainmtr' => $part['main_motor'],
                        'iothermtr' => $part['other_motor'],
                        'iheater' => $part['heater'],
                        'ilight' => $part['light'],
                        'iother' => $part['other'],
                        'strdimension' => $part['machine_dimension'],
                        'iweight' => $part['machine_weight'],
                        'strhidrolikoil' => $part['hidrolik_oil'],
                        'ivolume1' => $part['volume_hidrolik_oil'],
                        'strheateroil' => $part['heater_oil'],
                        'ivolume2' => $part['volume_heater_oil'],
                        'strgearoil' => $part['gear_oil'],
                        'ivolume3' => $part['volume_gear_oil'],
                        'strluboil' => $part['lubricant_oil1'],
                        'ivolume4' => $part['volume_lubricant_oil1'],
                        'strgrease' => $part['grease'],
                        'ivolume5' => $part['volume_grease'],
                        'strdiscontinue' => $part['discontinue'],
                        'strremark' => $part['remark'],
                        'dtinput' => $part['input_date'],
                        'dtupdate' => $part['update_date'],
                        'struser' => $part['current_user'],
                        'ipowerconstot' => $part['power_consumption_total'],
                        'strluboil2' => $part['lubricant_oil2'],
                        'ivolluboil2' => $part['volume_lubricant_oil2'],
                        'strluboil3' => $part['lubricant_oil3'],
                        'ivolluboil3' => $part['volume_lubricant_oil3'],
                        'iothermtr2' => $part['other_motor2'],
                        'dtnextinsp' => $part['next_inspection_date'],
                        'dtlastinsp' => $part['last_inspection_date'],
                        'dtrunning' => $part['running_status_date'],
                        'dtstandby' => $part['standby_status_date'],
                        'dttransfer' => $part['transfer_status_date'],
                        'dtscrap' => $part['scrap_status_date'],
                        'dtng' => $part['ng_status_date'],
                        'dthandover' => $part['handover_status_date'],
                        'dtreadytoho' => $part['handover_starting_process_date'],
                        'dtappmanf' => $part['handover_approved_manufacture_manager'],
                        'dtdistmtn' => $part['handover_distributed_maintenance_date'],
                        'dtappmtn' => $part['handover_approved_maintenance_manager'],
                        'dtdistuser' => $part['handover_distributed_user_section'],
                        'dtappuser' => $part['handover_approved_user_manager'],
                        'strreqnum' => $part['registration_number'],
                        'strinvoiceno' => $part['invoice_no'],
                        'strcost' => $part['cost'],
                        'strfreightcost' => $part['freight_cost'],
                        'strassetcode' => $part['asset_code'],
                        'budgetid' => $part['budget_id'],
                        'strwcdesc' => $part['wc_description'],

                    ]);
                }
                else if($type == 'updatemtamachine' )
                {
                    DB::connection('mta')->table('mmachine')
                    ->where( 'machid', $part['machine_id'])
                    ->update([
                        // set value yg diupdate
                        'strsectdesc' => $part['section_description'],
                        'strdept' => $part['departement'],
                        'strdiscontinue' => $part['state_discontinue'],
                    ]);
                }
            }
        }
        return response()->json(['message' => 'Import file successfully.'], 200);
    }
}
