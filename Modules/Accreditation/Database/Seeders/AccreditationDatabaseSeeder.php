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
            SeedSchoolsTableSeeder::class,
            AccredStatsTableSeeder::class,
            UsersTableSeeder::class,
            AcadPrgrmsTableSeeder::class,
            PrgrmAccredsTableSeeder::class,
        ]);
    }
}
