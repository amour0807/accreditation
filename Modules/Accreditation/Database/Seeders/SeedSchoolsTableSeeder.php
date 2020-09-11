<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeedSchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schools')->insert([
            'school_name' => 'School of Information Technology',
            'school_code' => 'SIT',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Engineering and Architecture',
            'school_code' => 'SEA',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Dentistry',
            'school_code' => 'SOD',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Natural Sciences',
            'school_code' => 'SNS',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Nursing',
            'school_code' => 'SON',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Business Administration and Accountancy',
            'school_code' => 'SBAA',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Teacher Education and Liberal Arts',
            'school_code' => 'STELA',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Law',
            'school_code' => 'SOL',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Criminal Justice and Public Safety',
            'school_code' => 'SCJPS',
        ]);
        DB::table('schools')->insert([
            'school_name' => 'School of Hospitality and Tourism Management',
            'school_code' => 'SIHTM',
        ]);

    }
}
