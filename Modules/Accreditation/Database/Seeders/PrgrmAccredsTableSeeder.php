<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrgrmAccredsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prgrm_accreds')->insert([
            'accred_stat_id' => '3',
            'acad_prgrm_id' => '1',
            'visit_date_from' => '2020-2-2',
            'from' => '2020-3-3',
            'to' => '2025-3-3',
            'current' => 'yes',
        ]);

        DB::table('prgrm_accreds')->insert([
            'accred_stat_id' => '6',
            'acad_prgrm_id' => '2',
            'visit_date_from' => '2020-2-2',
            'from' => '2020-3-3',
            'to' => '2025-3-3',
            'current' => 'yes',

        ]);

        DB::table('prgrm_accreds')->insert([
            'accred_stat_id' => '4',
            'acad_prgrm_id' => '3',
            'visit_date_from' => '2020-2-2',
            'from' => '2020-3-3',
            'to' => '2025-3-3',
            'current' => 'yes',
            
        ]);
    }
}
