<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccredStatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('accred_stats')->insert([
            'accred_status' => 'Orientation',
        ]);
        DB::table('accred_stats')->insert([
            'accred_status' => 'Candidate Status',
        ]);
        DB::table('accred_stats')->insert([
            'accred_status' => 'Level I Accredited Status',
        ]);
        DB::table('accred_stats')->insert([
            'accred_status' => 'Level II Reaccredited status',
        ]);
        DB::table('accred_stats')->insert([
            'accred_status' => 'Level II 1st Reaccredited status',
        ]);
        DB::table('accred_stats')->insert([
            'accred_status' => 'Level II 2nd Reaccredited status',
        ]);
        DB::table('accred_stats')->insert([
            'accred_status' => 'Level III Reaccredited status',
        ]);
        DB::table('accred_stats')->insert([
            'accred_status' => 'Level IV Accredited Status',
        ]);
    }
}
