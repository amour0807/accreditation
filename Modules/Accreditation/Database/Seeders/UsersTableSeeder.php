<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'qa@mail.com',
            'is_admin' => 1,
            'password' => bcrypt('123123123'),

        ]);

        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'email' => 'bsit@mail.com',
            'school_id' =>1,
            'is_admin' => 0,
            'password' => bcrypt('123123123'),

        ]);
    }
}
