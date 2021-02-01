<?php

namespace App\Imports;

use App\Alumni;
use Modules\AlumniDatabase\Entities\Survey;
use Illuminate\Support\Facades\{Hash};
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\Accreditation\Entities\AcadPrgrm;
use Throwable;

class AlumniImport implements ToModel //, SkipsOnError, WithValidation
{
    //use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $list = AcadPrgrm::where('acad_prog',$row[0])->first();
        $program_id = $list->id;
        $school_id = $list->school_id;

        $name = explode(", ", $row[2]);
        if(substr($name[1],-1) == '.'){
            $firstname = trim(substr($name[1], 0, -2));
            $middlename = substr($name[1],-2);
        }else{
            $firstname = trim($name[1]);
            $middlename = '';
        }
        $lastname = $name[0];
        $fname = substr($firstname, 0, 1);
        $email = $lastname.'_'.$fname;
    return new Alumni([
                 'id_number' => $row[1],
                 'first_name' => $firstname,
                 'middle_name' => $middlename,
                 'last_name' => $lastname,
                 'email' => $email,
                'user_role' => 'graduate',
                'school_id' => $school_id,
                'program_id' => $program_id,
                'current_address' => $row[3],
                'semester' => '1st Semester',
                'school_year' => '2020 - 2021',
                'password' => Hash::make($row[0]),
                'remarks' => 'To Evaluate'
            ]);
 
    
    
    }
}
