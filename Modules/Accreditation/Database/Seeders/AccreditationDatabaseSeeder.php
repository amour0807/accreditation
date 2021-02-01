<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccreditationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // AccredStatsTableSeeder::class,
            // UsersTableSeeder::class,
            // AccredStatsTableSeeder::class,
            // SeedSchoolsTableSeeder::class,
            // AcadPrgrmsTableSeeder::class,
            // PermissionSeeder::class,
            // RoleSeeder::class,
            AlumniSeeder::class,
            QuestionSeeder::class,
        ]);
    }
}
