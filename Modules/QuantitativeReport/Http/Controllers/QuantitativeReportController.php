<?php

namespace Modules\QuantitativeReport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use App\Employee;
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

class QuantitativeReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        $list = School::all();
        
        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id');
        if(!auth()->user()->hasRole('admin')){
            $acad_prog = $acad_prog->where('school_id', auth()->user()->school_id);
        }
        $acad_prog = $acad_prog->select('*','acad_prgrms.id as a_id');
        $acad_prog = $acad_prog->get();

        $school = School::where('id', auth()->user()->school_id)->first();
        $user_role = DB::table('users_roles')->where('user_id',auth()->user()->id)->first();
        $user = User::where('id',auth()->user()->id)->first();
        return view('quantitativereport::employee.employee', compact('school','acad_prog','user_role','user','list'));
    }
    public function employee_dtb(Request $request){
           $employee = Employee::all()->sortByDesc('school_year');
       
        return DataTables::of($employee)
           
           ->addColumn('actions', function($employee) {
            if(auth()->user()->hasPermission('edit-employees') && auth()->user()->hasPermission('delete-employees')){
                   return '
                       <a class="btn btn-info btn-sm" href="'.route("employeeEdit", $employee->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                       </a>
                       
                       <button class="btn btn-danger btn-sm destroy" title="Remove" empid="'.$employee->id.'"><i class="fa fa-trash"></i>
                       </button>
                       ';
            }else{
                return '
                       <a class="btn btn-info btn-sm" href="'.route("employeeEdit", $employee->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                       </a>
                       ';
            }
               
                   
           })
           ->rawColumns(['actions'])
           ->make(true);

           return view('quantitativereport::employee.employee', compact('employee'));
   }
   public function addEmployee(Request $request){
    $check = Employee::all();
    $success="";
  foreach($check as $ac){
      if($ac->department == $request->department && $ac->semester == $request->sem && $ac->school_year == $request->school_year){
          $success = false;
          $message = "Duplicate entry!";
          return response()->json([
              'success' => $success,
              'message' => $message,
          ]);
      }
  }

    $employee = new Employee;
    $employee->semester = $request->sem ;
    $employee->school_year = $request->school_year ;
    $employee->department = $request->department ;
     $employee->no_Tpermanent = $request->tpermanent;
     $employee->no_Tprobationary = $request->tprobationary;
     $employee->no_Tcontractual = $request->tcontractual;
    $employee->no_Tpartime = $request->tpartime;
     $employee->no_NTprobationary = $request->ntprobationary;
     $employee->no_NTpermanent = $request->ntpermanent;

    $employee->save();
    if (! $employee->save()) {
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

   public function updateEmployee(Request $request){

    $employee = Employee::find($request->id);
    $employee->semester = $request->sem ;
    $employee->school_year = $request->school_year ;
    $employee->department = $request->department ;
     $employee->no_Tpermanent = $request->tpermanent;
     $employee->no_Tprobationary = $request->tprobationary;
     $employee->no_Tcontractual = $request->tcontractual;
    $employee->no_Tpartime = $request->tpartime;
     $employee->no_NTprobationary = $request->ntprobationary;
     $employee->no_NTpermanent = $request->ntpermanent;

    $employee->save();
    return redirect()->route('hrInput')->with('update', '');
   }

   public function employeeEdit($id){
       
    $list = School::all();
    $employee = Employee::where('id', $id)->first();
     
     return view('quantitativereport::employee.employee-edit', compact('employee','list'));
 }
 public function deleteEmployee(Request $request){
     $employee = Employee::find($request->id);
     $employee->delete();
    
 }
 public function employeefilterReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $school = $request->select1; 
        $sem = $request->select2; 
        $schoolyear = $request->select3;
        $from = $request->from; 
        $to = $request->to;

        $queryBuilder = DB::table('hr_report')->join('schools','schools.school_code','hr_report.department');
            
            if($school){
                $queryBuilder = $queryBuilder->where('hr_report.department', $school);
            }

            if($sem){
                $queryBuilder =$queryBuilder->where('hr_report.semester', $sem);
            }

            if($schoolyear){
                $queryBuilder =$queryBuilder->where('hr_report.school_year', $schoolyear);
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

             $pdf = PDF::loadView('quantitativereport::reports.employee-report', compact('queryBuilder','school', 'sem', 'schoolyear','department'));
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
     // return view('quantitativereport::reports.employee-report', compact('queryBuilder','school', 'sem', 'schoolyear','department'));
    }
}
