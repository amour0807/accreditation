<?php

namespace Modules\AlumniDatabase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Alumni;
use Modules\AlumniDatabase\Entities\Survey;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Illuminate\Support\Facades\{Hash};
use Yajra\Datatables\Datatables;
use DB;
use PDF;


class ReportController extends Controller
{
    public function index()
    {
        $programs = AcadPrgrm::all();
        $schools = Alumni::join('qasystem.schools','qasystem.schools.id','alumni.users.school_id')->where('alumni.users.user_role','graduate')->distinct('school_name')->pluck('alumni.users.school_id','school_name');
        if(auth()->guard('alumni')->user()->user_role == 'secretary'){
            $id = auth()->guard('alumni')->user()->school_id;
         $programs = AcadPrgrm::where('school_id', $id)->get();
        }
        
        $question = DB::table('alumni.questions')->get();
        return view('alumnidatabase::reports.index',compact('question','schools','programs'));
    }
    public function report_dtb(Request $request){
            $survey = Survey::join('alumni.questions','alumni.questions.id','alumni.answers.question_id')
                    ->join('alumni.users','alumni.users.id','alumni.answers.alumni_id')
                    ->join('qasystem.schools','qasystem.schools.id','alumni.users.school_id')
                    ->join('qasystem.acad_prgrms','qasystem.acad_prgrms.id','alumni.users.program_id')
                    ->get();
        
        return DataTables::of($survey)
            
            ->rawColumns(['actions'])
            ->make(true);
    } 
    public function reportfilterReport(Request $request)
    {
        $id = auth()->guard('alumni')->user()->school_id;
        $department = School::where('id', $id)->first();
        $school = $request->school;
        $program = $request->program;
        $secprogram = $request->secprogram;
        $sem = $request->sem; 
        $schoolyear = $request->schoolyear;
        $schoolname = School::where('id',$school)->first();
        $progname = AcadPrgrm::all();
     
        // Questions Filter
        $questionSelected = $request->question;
        $questionList = DB::table('alumni.questions')->get();
        $programList = Alumni::join('qasystem.acad_prgrms','qasystem.acad_prgrms.id','alumni.users.program_id')->where('alumni.users.user_role','graduate');
        if(auth()->guard('alumni')->user()->user_role == 'secretary'){
            if($secprogram == 'ALL')
               $programList = $programList->where('alumni.users.school_id',$id);
            else
                $programList = $programList->where('qasystem.acad_prgrms.id', $secprogram);
        }else{
            if ($program != 'ALL' && $program != null) 
                $programList = $programList->where('alumni.school_year.id', $secprogram)->where('qasystem.acad_prgrms.id', $program);
            
        }

        $programList = $programList->distinct('acad_prog')->pluck('alumni.users.school_id','alumni.users.program_id');
        
        $schoolList = Alumni::join('qasystem.schools','qasystem.schools.id','alumni.users.school_id')->where('alumni.users.user_role','graduate');
        if(auth()->guard('alumni')->user()->user_role == 'secretary')
            $schoolList = $schoolList->where('alumni.users.school_id',$id);
        else
            if($school != 'ALL' )
                $schoolList = $schoolList->where('qasystem.schools.id',$school);
        
        $schoolList = $schoolList->distinct('school_name')->pluck('alumni.users.school_id','school_name');
        $queryBuilder = DB::table('alumni.answers')->join('alumni.questions','alumni.questions.id','alumni.answers.question_id')
        ->join('alumni.users','alumni.users.id','alumni.answers.alumni_id')
        ->join('qasystem.schools','qasystem.schools.id','alumni.users.school_id')
        ->join('qasystem.acad_prgrms','qasystem.acad_prgrms.id','alumni.users.program_id');

            if($sem){
                $queryBuilder =$queryBuilder->where('alumni.users.semester', $sem);
            }

            if($schoolyear){
                $queryBuilder =$queryBuilder->where('alumni.users.school_year', $schoolyear);
            }
            $queryBuiler = $queryBuilder->select('*','alumni.answers.question_id as q_id');
            $queryBuilder = $queryBuilder->get(); 

        $pdf = PDF::loadView('alumnidatabase::reports.report-report', compact('queryBuilder','program','school', 'sem', 'schoolyear','department','questionList','schoolname','progname','programList','schoolList','questionSelected','secprogram'));
        $pdf->setPaper('legal', 'portrait');

        return $pdf->stream('project_'.time().'.pdf');
    }
    public function school_select(Request $request){
        $programs = AcadPrgrm::where('school_id', $request->id)->get();

        echo '<select class="form-control-sm form-control" onchange="programchange()" id="program" name="program" required>';

        if ($programs->count() != 0){
            echo "<option value='ALL' >ALL</option>";
            foreach ($programs as $program) {
                echo "<option value='".$program->id."'>".$program->acad_prog."</option>";
            } 
        }else{
            echo "<option value='ALL' >ALL</option>";
        }
        echo "</select>";
    }
}
