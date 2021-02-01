<?php

namespace Modules\QuantitativeReport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\QuantitativeReport\Entities\Graduate;
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
class GraduateController extends Controller
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

        return view('quantitativereport::graduate.graduate', compact('school','acad_prog','user_role','user','list'));
    }
    public function graduate_select(Request $request){
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
    public function graduate_dtb(Request $request){
           $graduate = Graduate::join('schools','schools.id','graduate.school_id')
           ->join('acad_prgrms','acad_prgrms.id','graduate.acad_prog_id')
           ->orderBy('graduate.school_year')
           ->select('*','graduate.id as e_id')
           ->get();
       
        return DataTables::of($graduate)
           
           ->addColumn('actions', function($graduate) {
            if(auth()->user()->hasPermission('edit-graduate') && auth()->user()->hasPermission('delete-graduate')){
                   return '
                       <a class="btn btn-info btn-sm" href="'.route("graduateEdit", $graduate->e_id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                       </a>
                       
                       <button class="btn btn-danger btn-sm destroy" title="Remove" enid="'.$graduate->e_id.'"><i class="fa fa-trash"></i>
                       </button>
                       ';
            }else{
                return '
                       <a class="btn btn-info btn-sm" href="'.route("graduateEdit", $graduate->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                       </a>
                       ';
            }
               
                   
           })
           ->rawColumns(['actions'])
           ->make(true);

           return view('quantitativereport::graduate.graduate', compact('graduate'));
   }
   public function addgraduate(Request $request){
    $check = Graduate::all();
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
    $graduate = new Graduate;
    $graduate->school_id = $request->school ;
    $graduate->acad_prog_id = $request->program;
    $graduate->semester = $request->sem;
    $graduate->school_year = $request->school_year ;
     $graduate->undergrad = $request->undergrad;
     $graduate->non_degree = $request->nondegree;
     $graduate->basic_ed = $request->basiced;

    $graduate->save();
    if (! $graduate->save()) {
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
    
    $graduate = Graduate::find($request->id);
    $graduate->school_id = $request->school ;
    $graduate->acad_prog_id = $request->program;
    $graduate->semester = $request->sem ;
    $graduate->school_year = $request->school_year ;
     $graduate->undergrad = $request->undergrad;
     $graduate->non_degree = $request->nondegree;
     $graduate->basic_ed = $request->basiced;

    $graduate->save();
    return redirect()->route('graduate')->with('update', '');
   }

   public function graduateEdit($id){
       $list = School::where('school_name','like','%School%')->get();


        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id');
        if(!auth()->user()->hasRole('admin')){
            $acad_prog = $acad_prog->where('school_id', auth()->user()->school_id);
        }
        $acad_prog = $acad_prog->select('*','acad_prgrms.id as a_id');
        $acad_prog = $acad_prog->get();

    $graduate = Graduate::join('schools','schools.id','graduate.school_id')
    ->join('acad_prgrms','acad_prgrms.id','graduate.acad_prog_id')
    ->select('*','graduate.id as e_id')
    ->where('graduate.id', $id)->first();

     return view('quantitativereport::graduate.graduate-edit', compact('graduate','list','acad_prog'));
 }
 public function deleteEnrollment(Request $request){
     $graduate = Graduate::find($request->id);
     $graduate->delete();
    
 }
 public function graduatefilterReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $school = $request->select1; 
        $program = $request->select2; 
        $sem = $request->select3; 
        $schoolyear = $request->select4;
        $from = $request->from; 
        $to = $request->to;
        
        $queryBuilder = DB::table('graduate')->join('schools','schools.id','graduate.school_id')
        ->join('acad_prgrms','acad_prgrms.id','graduate.acad_prog_id');
            
            if($school){
                $queryBuilder = $queryBuilder->where('school_code', $school);
            }
            if($program){
                $queryBuilder = $queryBuilder->where('acad_prog_code', $program);
            }

            if($sem){
                $queryBuilder =$queryBuilder->where('graduate.semester', $sem);
            }

            if($schoolyear){
                $queryBuilder =$queryBuilder->where('graduate.school_year', $schoolyear);
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

              $pdf = PDF::loadView('quantitativereport::reports.graduate-report', compact('queryBuilder','program','school', 'sem', 'schoolyear','department'));
         $pdf->setPaper('legal', 'landscape');
         $pdf->save(storage_path().'_filename.pdf');

         return $pdf->stream('project_'.time().'.pdf');
      // return view('quantitativereport::reports.graduate-report', compact('queryBuilder','program','school', 'sem', 'schoolyear','department'));
    }
}
