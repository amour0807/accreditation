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
            'last_name' => 'Office',
            'first_name' => 'Quality Assurance',
            'user_role' => 'Admin',
            'username' => 'QAO_HaloverE',
            'is_admin' => 1,
            'password' => bcrypt('123123123'),
            'status' => 'Login',
        ]);
    }
}
