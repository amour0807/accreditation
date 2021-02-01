<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alumni.users')->insert([
            'id_number' => 1,
            'last_name' => 'Office',
            'first_name' => 'Quality Assurance',
            'user_role' => 'secretary',
            'email' => 'qao@ubaguio.edu',
            'school_id' => 1,
            'program_id' => 2,
            'remarks' => 'admin',
            'password' => bcrypt('alumniAdmin'),
        ]);
    }
}
