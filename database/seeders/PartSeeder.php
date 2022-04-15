<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        for($i = 0; $i < 10; $i++) {
            DB::table('parts')->insert([
                "part_id" => 'Part'. $i,
                "part_name" => 'Nama Part',
                "type" => 'tipe',
                "brand" => 'Brandnya',
                "maker" => 'Makernya',
                "location" => 'Jakarta',
                "min_stock" => '20',
                "rop" => '1',
                "designation" => '',
                "remark" => '',
                "created_at" => $now,
                "updated_at" => $now,
            ]);
        }
    }
}
