<?php

namespace App\Imports;

use App\Alumni;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Modules\AlumniDatabase\Entities\Survey;
use Illuminate\Support\Facades\{Hash};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class AlumniImport implements ToCollection, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            
        $schoolID = School::select('id')->where('school_name',$row[11])->value('id');
        $progID = AcadPrgrm::select('id')->where('acad_prog',$row[12])->value('id');
            $alumni = Alumni::create([
                'id_number' => $row[0],
                'last_name' => $row[1],
               'first_name' => $row[2],
               'middle_name' => $row[3],
               'user_role' => 'graduate',
               'school_id' => $schoolID,
               'program_id' => $progID,
               'current_address' => $row[4],
               'present_address' => $row[5],
               'email' => $row[6],
               'cell_num' => $row[7],
               'landline' => $row[8],
               'facebook' => $row[9],
               'linkedin' => $row[10],
               'major' => $row[13],
               'semester' => '1st Semester',
               'school_year' => '2020',
               'password' => Hash::make($row[0]),
               'remarks' => 'To Evaluate'
            ]);

            $questions = array( "q1" => $row[14],
            "q2" => $row[16],
            "q3" => $row[17],
            "q4" => $row[18],
            "q5" => $row[19],
            "q6" => $row[20],
            "q7" => $row[21],
            "q8" => $row[22],
            "q9" => $row[24],
            "q10" => $row[25],
            "q11" => $row[28],
            "q12" => $row[15],
        );
            
            foreach($questions as $qnumber => $qanswer){
                $str = ltrim($qnumber, 'q');
                if($qanswer != ""){
                    $alumni->answer()->create([
                        'question_id' => $str,
                        'answer' => $qanswer
                        ]);
                }
            }
        }
    }
    
    public function rules(): array 
    {
        return [
            '*.6' => ['email','unique:mysql2.users,email']
        ];
    }
}
