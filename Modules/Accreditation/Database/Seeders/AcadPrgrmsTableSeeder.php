<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcadPrgrmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('acad_prgrms')->insert([
            'school_id' => '1',
            'acad_prog_code' => 'BSIT',
            'acad_prog' => 'Bachelor of Science in Information Technology',
        ]);
        DB::table('acad_prgrms')->insert([
            'school_id' => '1',
            'acad_prog_code' => 'BSCS',
            'acad_prog' => 'Bachelor of Science in Computer Schience',
        ]);
        DB::table('acad_prgrms')->insert([
            'school_id' => '1',
            'acad_prog_code' => 'COE',
            'acad_prog' => 'Bachelor of Science in Computer Engineering',
        ]);

        DB::table('acad_prgrms')->insert([
            'school_id' => '2',
            'acad_prog_code' => 'BSSE',
            'acad_prog' => 'Bachelor of Science in Sanitary Engineering',
        ]);
        DB::table('acad_prgrms')->insert([
            'school_id' => '2',
            'acad_prog_code' => 'BSCE',
            'acad_prog' => 'Bachelor of Science in Civil Engineering',
        ]);
        DB::table('acad_prgrms')->insert([
            'school_id' => '2',
            'acad_prog_code' => 'BSEE',
            'acad_prog' => 'Bachelor of Science in Electrical Engineering',
        ]);
        
    }
}
