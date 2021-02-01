<?php

namespace Modules\QuantitativeReport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\QuantitativeReport\Entities\Enrollment;
use Modules\Accreditation\Entities\School;
use Yajra\Datatables\Datatables;
use App\User;
use DB;
use Validator;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use PDF;
use PdfReport;
use \Carbon\Carbon;
use Session;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        $list = School::where('school_name','like','%School%')->get();
        

        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id');
        if(!auth()->user()->hasRole('admin')){
            $acad_prog = $acad_prog->where('school_id', auth()->user()->school_id);
        }
        $acad_prog = $acad_prog->select('*','acad_prgrms.id as a_id');
        $acad_prog = $acad_prog->get();

        $school = School::where('id', auth()->user()->school_id)->first();
        $user_role = DB::table('users_roles')->where('user_id',auth()->user()->id)->first();
        $user = User::where('id',auth()->user()->id)->first();

        return view('quantitativereport::enrollment.enrollment', compact('school','acad_prog','user_role','user','list'));
    }
    public function enrollment_select(Request $request){
        $programs = AcadPrgrm::where('school_id', $request->id)->get();
        $prgselect = $request->prgselect;
        echo '<select class="form-control-sm form-control" onchange="programchange()" id="program" name="program" required>';

        if ($programs->count() != 0){
            foreach ($programs as $program) {
                echo "<option value='".$program->id."'>".$program->acad_prog."</option>";
            } 
        }else{
            echo "<option disabled selected value >No Academic Program Added yet</option>";
        }
        
        echo "</select>";
    }
    public function enrollment_dtb(Request $request){
           $enrollment = Enrollment::join('schools','schools.id','enrollment.school_id')
           ->join('acad_prgrms','acad_prgrms.id','enrollment.acad_prog_id')
           ->orderBy('enrollment.school_year')
           ->select('*','enrollment.id as e_id')
           ->get();
       
        return DataTables::of($enrollment)
           
           ->addColumn('actions', function($enrollment) {
            if(auth()->user()->hasPermission('edit-enrollment') && auth()->user()->hasPermission('delete-enrollment')){
                   return '
                       <a class="btn btn-info btn-sm" href="'.route("enrollmentEdit", $enrollment->e_id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                       </a>
                       
                       <button class="btn btn-danger btn-sm destroy" title="Remove" enid="'.$enrollment->e_id.'"><i class="fa fa-trash"></i>
                       </button>
                       ';
            }else{
                return '
                       <a class="btn btn-info btn-sm" href="'.route("enrollmentEdit", $enrollment->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                       </a>
                       ';
            }
               
                   
           })
           ->rawColumns(['actions'])
           ->make(true);

           return view('quantitativereport::enrollment.enrollment', compact('enrollment'));
   }
   public function addEnrollment(Request $request){
    $check = Enrollment::all();
    $success="";
  foreach($check as $ac){
      if($ac->school_id == $request->school && $ac->acad_prog_id == $request->program && $ac->semester == $request->sem && $ac->school_year == $request->school_year){
          $success = false;
          $message = "Duplicate entry!";
          return response()->json([
              'success' => $success,
              'message' => $message,
          ]);
      }
  }

    $enrollment = new Enrollment;

    $enrollment->school_id = $request->school ;
    $enrollment->acad_prog_id = $request->program;
    $enrollment->semester = $request->sem ;
    $enrollment->school_year = $request->school_year ;
     $enrollment->freshmen = $request->freshmen;
     $enrollment->transfery = $request->transfery;
     $enrollment->old_student = $request->oldstud;
     $enrollment->returnee = $request->returnee;

    $enrollment->save();
    if (! $enrollment->save()) {
        throw new Exception('Error in saving data.');
    } else {
        $success = true;
        $message = "Successfuly Saved!";
    }
     return response()->json([
        'success' => $success,
        'message' => $message,
    ]);
   }

   public function updateEnrollment(Request $request){

    $enrollment = Enrollment::find($request->id);

    $enrollment->school_id = $request->school ;
    $enrollment->acad_prog_id = $request->program;
    $enrollment->semester = $request->sem ;
    $enrollment->school_year = $request->school_year ;
     $enrollment->freshmen = $request->freshmen;
     $enrollment->transfery = $request->transfery;
     $enrollment->old_student = $request->oldstud;
     $enrollment->returnee = $request->returnee;

    $enrollment->save();

    return redirect()->route('enrollment')->with('update', '');
   }

   public function enrollmentEdit($id){
       $list = School::where('school_name','like','%School%')->get();


        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id');
        if(!auth()->user()->hasRole('admin')){
            $acad_prog = $acad_prog->where('school_id', auth()->user()->school_id);
        }
        $acad_prog = $acad_prog->select('*','acad_prgrms.id as a_id');
        $acad_prog = $acad_prog->get();

    $enrollment = Enrollment::join('schools','schools.id','enrollment.school_id')
    ->join('acad_prgrms','acad_prgrms.id','enrollment.acad_prog_id')
    ->select('*','enrollment.id as e_id')
    ->where('enrollment.id', $id)->first();

     return view('quantitativereport::enrollment.enrollment-edit', compact('enrollment','list','acad_prog'));
 }
 public function deleteEnrollment(Request $request){
     $enrollment = Enrollment::find($request->id);
     $enrollment->delete();
    
 }
 public function enrollmentfilterReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $school = $request->select1; 
        $program = $request->select2; 
        $sem = $request->select3; 
        $schoolyear = $request->select4;
        $from = $request->from; 
        $to = $request->to;

        $queryBuilder = DB::table('enrollment')->join('schools','schools.id','enrollment.school_id')
        ->join('acad_prgrms','acad_prgrms.id','enrollment.acad_prog_id');
            
            if($school){
                $queryBuilder = $queryBuilder->where('school_code', $school);
            }
            if($program){
                $queryBuilder = $queryBuilder->where('acad_prog_code', $program);
            }

            if($sem){
                $queryBuilder =$queryBuilder->where('enrollment.semester', $sem);
            }

            if($schoolyear){
                $queryBuilder =$queryBuilder->where('enrollment.school_year', $schoolyear);
            }
            if($from != 'All' && $to != 'All'){
                $syfrom = ($from-1).' - '.$from;
                $syto = ($to-1).' - '.$to;
                $queryBuilder = $queryBuilder->where(function ($queryBuilder) use($syfrom, $syto){
                    $queryBuilder->where('school_year', '>=', $syfrom)
                        ->where('school_year', '<=', $syto);
                });
            }

            $queryBuilder = $queryBuilder->get();

        $pdf = PDF::loadView('quantitativereport::reports.enrollment-report', compact('queryBuilder','program','school', 'sem', 'schoolyear','department'));
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
        // return view('quantitativereport::reports.enrollment-report', compact('queryBuilder','program','school', 'sem', 'schoolyear','department'));
    }
}
