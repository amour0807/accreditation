<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Survey;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Illuminate\Support\Facades\{Hash};
use Yajra\Datatables\Datatables;
use DB;


class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }
    public function report_dtb(Request $request){
            // $graduate = User::join('schools','schools.id','users.school_id')
            // ->join('acad_prgrms','acad_prgrms.id','users.program_id')
            // ->join('answers','answers')
            // ->select('*','users.id as e_id')
            // ->get();
            $survey = DB::connection('mysql2')->table('answers')->join('questions','questions.id','answers.question_id')
                    ->join('users','users.id','answers.user_id')
                    ->join('schools','schools.id','users.school_id')
                    ->join('acad_prgrms','acad_prgrms.id','users.program_id')
                    ->get();
        
        return DataTables::of($survey)
            
            ->rawColumns(['actions'])
            ->make(true);
    } 
    public function reportfilterReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $school = $request->select1; 
        $program = $request->select2; 
        $sem = $request->select3; 
        $schoolyear = $request->select4;
        $question = $request->select5;
        $schoolID = School::where('school_code',$school)->first();
        $progID = AcadPrgrm::where('acad_prog_code',$program)->first();

        $queryBuilder =  DB::connection('mysql2')->table('answers')->join('questions','questions.id','answers.question_id')
                    ->join('users','users.id','answers.user_id')
                    ->join('schools','schools.id','users.school_id')
                    ->join('acad_prgrms','acad_prgrms.id','users.program_id');
            
            if($school){
                $queryBuilder = $queryBuilder->where('users.school_id', $schoolID->id);
            }
            if($program){
                $queryBuilder = $queryBuilder->where('users.program_id', $progID->id);
            }

            if($sem){
                $queryBuilder =$queryBuilder->where('users.semester', $sem);
            }

            if($schoolyear){
                $queryBuilder =$queryBuilder->where('users.school_year', $schoolyear);
            }
            if($question){
                $queryBuilder =$queryBuilder->where('questions.question', $question);
            }

            $queryBuilder = $queryBuilder->get();

        //      $pdf = PDF::loadView('quantitativereport::reports.employee-report', compact('queryBuilder','department', 'sem', 'schoolyear'));
        // $pdf->setPaper('legal', 'landscape');
        // $pdf->save(storage_path().'_filename.pdf');

        // return $pdf->stream('project_'.time().'.pdf');
        return view('reports.report-report', compact('queryBuilder','program','school', 'sem', 'schoolyear','department','question'));
    }
}
