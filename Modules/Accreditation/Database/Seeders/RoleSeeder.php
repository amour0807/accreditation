<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->role_name = 'Admin';
        $admin->slug = 'admin';
        $admin->save();

        $schoolSec = new Role();
        $schoolSec->role_name = 'School Secretary';
        $schoolSec->slug = 'school-secretary';
        $schoolSec->save();

        $dean = new Role();
        $dean->role_name = 'Dean / Principal';
        $dean->slug = 'dean-principal';
        $dean->save();

        $director = new Role();
        $director->role_name = 'Director / Head';
        $director->slug = 'director-head';
        $director->save();

        $execom = new Role();
        $execom->role_name = 'Executive Committee';
        $execom->slug = 'execom';
        $execom->save();
    }
}
