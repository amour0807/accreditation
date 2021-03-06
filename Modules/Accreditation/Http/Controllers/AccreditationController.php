<?php

namespace Modules\Accreditation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AccredStat;
use Modules\Accreditation\Entities\PrgrmAccred;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Yajra\Datatables\Datatables;
use DB;

use Illuminate\Support\Facades\File;

use PDF;
use Session;
class AccreditationController extends Controller
{
 
    public function adminAcred_prog()
    {
        $programs = PrgrmAccred::join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
        ->join('schools','schools.id','acad_prgrms.school_id')
        ->where('current', 'yes')
        ->select('*','prgrm_accreds.id as a_id');
        $sid = auth()->user()->school_id;
        if(!auth()->user()->hasRole('admin')){
            $programs = $programs->where('schools.id',$sid);
        }
        $programs = $programs->get();
        
        return view('accreditation::index', compact('programs'));
    }

    public function index(){
        //check date
        $expiring = PrgrmAccred::where('to', '<',DB::raw('DATE_ADD(NOW(), INTERVAL 1 YEAR)'))
                    ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                    ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                    ->where('current', 'yes')
                    ->join('accred_stats', 'accred_stats.id', 'prgrm_accreds.accred_stat_id')
                    ->select('*','prgrm_accreds.id as a_id')
                    ->get();
        if(count($expiring) > 0 ){
                    Session::flash('message', 'This is a message!'); }
        //Lvl 4
        $count6 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 2)
                ->where('current', 'yes')
                ->count();
        $count5 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 1)
                ->where('current', 'yes')

                ->count();
        $count4 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 8)
                ->where('current', 'yes')

                ->count();
        $count3 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 7)
                ->where('current', 'yes')

                ->count();
        $count2 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where(function ($query) {
                $query->where('prgrm_accreds.accred_stat_id', 4)
                    ->orWhere('prgrm_accreds.accred_stat_id', 5)
                    ->orWhere('prgrm_accreds.accred_stat_id', 6);
            })
                ->where('current', 'yes')
                ->count();

        $count1 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 3)
                ->where('current', 'yes')

                ->count();
                $no = 0;
                $no++;
        $topnotcher = DB::table('topnotchers')->where('is_updated',0)
                ->count();
        $activeP = DB::table('partners')
                ->where('status', 'Active')
                ->count();
        $inactiveP = DB::table('partners')
                ->where('status', 'Inactive')
                ->count();
      
        return view('accreditation::dashboard', compact('count1', 'count2', 'count3' ,'count4', 'count5', 'count6', 'expiring','topnotcher','activeP','inactiveP'));

    }
    //History datatable
    public function history_dtb($id){
        $no = 0;
        $programs = PrgrmAccred::join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
        ->where('acad_prgrms.id', $id)
        ->where('prgrm_accreds.archived', $no)
        // ->where('current', 'yes')
        ->select('*','prgrm_accreds.id as a_id')
        ->orderBy('prgrm_accreds.to','DESC')
        ->get();    

         return DataTables::of($programs)
            
            ->addColumn('accred_stat', function($programs) {
                    return $programs->accredStat->accred_status;
            })
            ->addColumn('cert1', function($programs) {
                if(empty($programs->pacucoa_cert)){
                    return 'None';
                }else{
                    return '<a target="_blank" href="'.asset('uploads/'.$programs->faap_cert).'">View Certificate</a>';
                }
            })
            ->addColumn('cert2', function($programs) {
                if(empty($programs->pacucoa_cert)){
                    return 'None';
                }else{
                    return '<a target="_blank" href="'.asset('uploads/'.$programs->pacucoa_cert).'">View Certificate</a>';
                }
            })
            ->addColumn('cert3', function($programs) {
                if(empty($programs->pacucoa_report)){
                    return 'None';
                }else{
                    return '<a target="_blank" href="'.asset('uploads/'.$programs->pacucoa_report).'">View Report</a>';
                }
            })
            ->addColumn('validity', function($programs) {
                $dateValue_from = $programs->from;
                $dateValue = $programs->to;
                //display in words
                $time_from=strtotime($dateValue_from);
                $month_from=date("M",$time_from);
                $year_from=date("Y",$time_from);

                //display in words
                $time=strtotime($dateValue);
                $month=date("M",$time);
                $year=date("Y",$time);

                return $month_from.' '.$year_from.' - '.$month.' '.$year;
            })
            ->addColumn('visit_date', function($programs) {
                if($programs->visit_date_to){
                    return $programs->visit_date_from.' - '.$programs->visit_date_to;
                }else{
                    return $programs->visit_date_from;
                }
            })
           
            ->addColumn('actions', function($programs) {
                    return '<th style="white-space: nowrap" class=" last"><a class="btn btn-secondary btn-sm" href="'.route("accredDetails", $programs->a_id).'">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-secondary btn-sm delete" progid="'.$programs->a_id.'"><i class="fa fa-trash"></i>
                        </button></th>
                        ';
            })
            
            ->rawColumns(['validity', "program", "accred_stat", "actions", 'cert1', 'cert2', 'cert3','visit_date'])
            ->make(true);
    }

    //Add school
    public function addSchoolForm(Request $request){
        $scheck = School::all();
        foreach($scheck as $sc){
            if($sc->school_code == $request->school_code){
                $success = false;
                $message = "Duplicate entry!";
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
            $school = new School;
            $school->school_name = $request->school_name;
            $school->school_code = $request->school_code;
            $school->save();
            
            if (! $school->save()) {
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

    public function deleteSchoolDept(Request $request){
        $school = School::find($request->id);
        $school->delete();
    }
    public function editSchoolDept(Request $request){
        $school = School::find($request->id);
        echo '
        <label><span class="text-danger"> * Required Fields</span></label><br><label><span class="text-danger">*</span>School Code</label> <input type="text" class="form-control" name="school_code" required value="'.$school->school_code.'"></input>
            <label><span class="text-danger">*</span>School Name</label> <input type="text" class="form-control" name="school_name" required value="'.$school->school_name.'"></input>

            <input type="hidden" name="sid" value="'.$request->id.'"></input>';      
    }
    public function updateSchoolDept(Request $request){
        $school = School::find($request->sid);
        $school->school_code = $request->school_code;
        $school->school_name = $request->school_name;
        $school->save();
        
            if (! $school->save()) {
                throw new Exception('Error in saving data.');
            } else {
                $success = true;
                $message = "Successfuly Updated!";
            }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    //Academic Program
     public function addAcadProg(Request $request){
        $acad_code = AcadPrgrm::all();
        foreach($acad_code as $ac){
            if($ac->acad_prog_code == $request->acad_prog_code){
                $success = false;
              $message = "Duplicate entry!";
              return response()->json([
                  'success' => $success,
                  'message' => $message,
              ]);
            }
        }
          $acad = new AcadPrgrm;
          $acad->school_id = $request->school_id;
          $acad->acad_prog_code = $request->acad_prog_code;
          $acad->acad_prog = $request->acad_prog;
          $acad->status = $request->status;
          $acad->save();
          
          if (! $acad->save()) {
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
     public function editAcadProg(Request $request){
        $programs = AcadPrgrm::find($request->id);
        echo '
        <label><span class="text-danger"> * Required Fields</span></label><br>
        <div class="col-md-6 col-sm-6">
        <label><span class="text-danger">*</span>Program Code</label>
        <input type="text" class="form-control" name="acad_prog_code" required value="'.$programs->acad_prog_code.'" class="form-control">
      </div>
      <div class="col-md-6 col-sm-6">
        <label><span class="text-danger">*</span>Status</label>
        <select class="form-control" name="status">
          <option value="Active" '.$programs->status.' == "Active" ? "selected":"">Active</option>
          <option value="Inactive" '.$programs->status.' == "Inactive" ? "selected":"">Inactive</option>
          <option value="Closed" '.$programs->status.' == "Closed" ? "selected":"">Closed</option>
        </select>
      </div>
            <label><span class="text-danger"> *</span>Program</label> <input type="text" class="form-control" name="acad_prog" required value="'.$programs->acad_prog.'"></input>

            <input type="hidden" name="sid" value="'.$request->id.'"></input>';      
    }
    public function updateAcadProg(Request $request){
       
        $programs = AcadPrgrm::find($request->sid);
        $programs->acad_prog_code = $request->acad_prog_code;
        $programs->acad_prog = $request->acad_prog;
        $programs->save();

            if (! $programs->save()) {
                throw new Exception('Error in saving data.');
            } else {
                $success = true;
                $message = "Successfuly Updated!";
            }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }
     public function deleteAcadProg(Request $request){
        $programs = AcadPrgrm::find($request->id);
        $programs->delete();

        
    }
    //Program Datatables
    public function program_dtb($id){
        $programs = PrgrmAccred::join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
        ->where('acad_prgrms.school_id', $id)
        ->where('current', 'yes')
        ->select('*','prgrm_accreds.id as a_id')
        ->get();    

         return DataTables::of($programs)
            ->addColumn('program', function($programs) {

                return $programs->acadPrgrm->acad_prog_code;
            })
            ->addColumn('accred_stat', function($programs) {
                    return $programs->accredStat->accred_status;
            })
            ->addColumn('cert1', function($programs) {
                if(empty($programs->faap_cert)){
                    return ' ';
                }else{
                    return '<i class="fa fa-check "></i>';
                }
            })
            ->addColumn('cert2', function($programs) {
                if(empty($programs->pacucoa_cert)){
                    return ' ';
                }else{
                    return '<i class="fa fa-check"></i>';
                }
            })
            ->addColumn('cert3', function($programs) {
                if(empty($programs->pacucoa_report)){
                    return ' ';
                }else{
                    return '<i class="fa fa-check"></i>';
                }
            })
            ->addColumn('from', function($programs) {
                $dateValue_from = $programs->from;
                $dateValue = $programs->to;
                //display in words
                $time_from=strtotime($dateValue_from);
                $month_from=date("M",$time_from);
                $year_from=date("Y",$time_from);

                //display in words
                $time=strtotime($dateValue);
                $month=date("M",$time);
                $year=date("Y",$time);

                return $month_from.' '.$year_from.' - '.$month.' '.$year;
            })
            ->addColumn('visit_date', function($programs) {
                if($programs->visit_date_to){
                    return $programs->visit_date_from.' - '.$programs->visit_date_to;
                }else{
                    return $programs->visit_date_from;
                }
            })
           
            ->addColumn('actions', function($programs) {
                    return '<a class="btn btn-secondary btn-sm" href="'.route("accredDetails", $programs->a_id).'">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        
                        <a class="btn btn-secondary btn-sm" href="'.route("accredHistory", $programs->AcadPrgrm->id).'"><i class="fa fa-history" aria-hidden="true"></i>
                        </a>
                        ';
            })
            
            ->rawColumns(['from', 'to',"program", "accred_stat", "actions", 'cert1', 'cert2', 'cert3','visit_date'])
            ->make(true);
    }
     public function acadprogram_dtb(){
      
          $programs = School::join('acad_prgrms', 'acad_prgrms.school_id', 'schools.id')
                ->orderBy('acad_prgrms.acad_prog','asc')
                ->get(); 
          

         return DataTables::of($programs)
            ->addColumn('actions', function($programs) {
                
            if (auth()->user()->hasPermission('create-school','delete-school')) {
                return '
                        <button class="btn btn-secondary btn-sm edit" programid="'.$programs->id.'"><i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm destroy" programid="'.$programs->id.'"><i class="fa fa-trash"></i>
                        </button>';
                }else{
                    return '
                        <button class="btn btn-secondary btn-sm edit" programid="'.$programs->id.'"><i class="fa fa-edit"></i>
                        </button>';
                }
            })
            
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function accredDetails($id){
        $program = PrgrmAccred::where('id', $id)->first();

        return view('accreditation::accreditation-details', compact('program'));

    }
    public function acadProgDetails($id){
        $acad_prgrms = AcadPrgrm::where('school_id', $id)->first();

        return view('accreditation::acadprog-details', compact('acad_prgrms'));

    }
    public function accredEdit($id){
        $program = PrgrmAccred::where('id', $id)->first();
        $accredStats = AccredStat::all();

        return view('accreditation::accreditation-edit', compact('program', 'accredStats'));
    }
    public function saveEdit(Request $request) {
        
        $programs = PrgrmAccred::where('id', $request->id)->first();

        $programs->accred_stat_id  =  $request->accredStat;

        $programs->visit_date_from =  $request->visitFrom;
        $programs->visit_date_to =  $request->visitTo;
        $programs->from =  $request->validFrom;
        $programs->to =  $request->validTo;
        $programs->remarks =  $request->remarks;

        
        $programs->save();

        $program = PrgrmAccred::where('id', $request->id)->first();
       

         return redirect()->route('accredDetails', $request->id)->with('success','');
       
    }
    public function accredHistory($id){
        $program = PrgrmAccred::where('acad_prgrm_id', $id)->first();

        return view('accreditation::history', compact('program'));

    }
    public function add_accred_form(){
        $schools = School::where('school_name','like','%School%')->get();
        $accredStats = AccredStat::all();

        return view('accreditation::add-accreditation', compact('schools', 'accredStats'));

    }
    public function school_select(Request $request){
        $programs = AcadPrgrm::where('school_id', $request->id)->get();

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
    // add Accreditation
    public function addAccred(Request $request){
        $faap_cert_fileName='';
        $pacucoa_cert_fileName='';

        $pacucoa_report_fileName='';
            $request->validate([
            'faap_cert' => 'nullable|mimes:jpeg,png,pdf|max:10240',
            'pacucoa_cert' => 'nullable|mimes:jpeg,png,pdf|max:10240',
            'pacucoa_report' => 'nullable|mimes:jpeg,png,pdf|max:10240',
            ]);
      
        if($request->hasFile('faap_cert')){
            
            $faap_cert_fileName = 'faap_cert_'.time().'.'.request()->faap_cert->getClientOriginalExtension();  
       
            request()->faap_cert->move(public_path('uploads'), $faap_cert_fileName);
        }
        if($request->hasFile('pacucoa_report')){
            
            $pacucoa_report_fileName = 'pacucoa_report_'.time().'.'.request()->pacucoa_report->getClientOriginalExtension();  
       
            request()->pacucoa_report->move(public_path('uploads'), $pacucoa_report_fileName);
        }
        if($request->hasFile('pacucoa_cert')){
            
            $pacucoa_cert_fileName = 'pacucoa_cert_'.time().'.'.request()->pacucoa_cert->getClientOriginalExtension();  
       
            request()->pacucoa_cert->move(public_path('uploads'), $pacucoa_cert_fileName);
        }
        

        //remove current status
        $remove = PrgrmAccred::where('current', 'yes')
        ->where('acad_prgrm_id', $request->program)->first();
        if($remove != null){
           $remove->current= '';
            $remove->save(); 
        }
        
        if($request->visit_date_to && $request->visit_date){
            DB::table('prgrm_accreds')->insert(
                [
                'accred_stat_id' => $request->accredStat, 
                'acad_prgrm_id' => $request->program,
                'from' => $request->from."-01",
                'to' => $request->to.'-01',
                'visit_date_from' => $request->visit_date,
                'visit_date_to' => $request->visit_date_to,
                'faap_cert' => $faap_cert_fileName,
                'pacucoa_report' => $pacucoa_report_fileName,
                'pacucoa_cert' => $pacucoa_cert_fileName,
                'current' => 'yes',
                'remarks' => $request->remarks,
                'archived' => 0,
                ]
            );
        }else{
            DB::table('prgrm_accreds')->insert(
                [
                'accred_stat_id' => $request->accredStat, 
                'acad_prgrm_id' => $request->program,
                'from' => $request->from.'-01',
                'to' => $request->to.'-01',
                'faap_cert' => $faap_cert_fileName,
                'pacucoa_report' => $pacucoa_report_fileName,
                'pacucoa_cert' => $pacucoa_cert_fileName,
                'current' => 'yes',

                'remarks' => $request->remarks,
                'archived' => 0,
                ]
            );
        }
        return redirect()->back()->with('success','');
    }
    public function school_dtb(){

        $programs = PrgrmAccred::join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
        ->join('schools','schools.id','acad_prgrms.school_id')
        ->where('archived', 0)
        ->where('current', 'yes');

        $sid = auth()->user()->school_id;
        if(!auth()->user()->hasRole('admin')){
            $programs->where('schools.id',$sid);
        }
        $programs->select('*','prgrm_accreds.id as a_id');
        $programs->get();
         return DataTables::of($programs)
            ->addColumn('program', function($programs) {

                return $programs->acadPrgrm->acad_prog_code;
            })
            ->addColumn('accred_prgrms', function($school) {
            $countAccredprgrams = AcadPrgrm::
            where('school_id', $school->id)->
            count();
                return $countAccredprgrams;
        })
            ->addColumn('accred_stat', function($programs) {
                    return $programs->accredStat->accred_status;
            })
            ->addColumn('cert1', function($programs) {
                if(empty($programs->faap_cert)){
                    return ' ';
                }else{
                    return '<i class="fa fa-check "></i>';
                }
            })
            ->addColumn('cert2', function($programs) {
                if(empty($programs->pacucoa_cert)){
                    return ' ';
                }else{
                    return '<i class="fa fa-check"></i>';
                }
            })
            ->addColumn('cert3', function($programs) {
                if(empty($programs->pacucoa_report)){
                    return ' ';
                }else{
                    return '<i class="fa fa-check"></i>';
                }
            })
            ->addColumn('from', function($programs) {
                $dateValue_from = $programs->from;
                $dateValue = $programs->to;
                //display in words
                $time_from=strtotime($dateValue_from);
                $month_from=date("M",$time_from);
                $year_from=date("Y",$time_from);

                //display in words
                $time=strtotime($dateValue);
                $month=date("M",$time);
                $year=date("Y",$time);

                return $month_from.' '.$year_from.' - '.$month.' '.$year;
            })
            ->addColumn('visit_date', function($programs) {
                if($programs->visit_date_to){
                    $vdfrome = strtotime($programs->visit_date_from);
                    $vdto = strtotime($programs->visit_date_to);
                    $vdf = date("M d, yy", $vdfrome);
                    $vdt = date("M d, yy", $vdto);
                    return $vdf.' - '.$vdt;
                }else{
                    return $programs->visit_date_from;
                }
            })
           
            ->addColumn('actions', function($programs) {
                return '<a class="btn btn-secondary btn-sm" href="'.route("accredDetails", $programs->a_id).'">
                <i class="fa fa-eye" aria-hidden="true"></i>
                </a> 
            <a class="btn btn-secondary btn-sm" href="'.route("accredHistory", $programs->AcadPrgrm->id).'"><i class="fa fa-history" aria-hidden="true"></i>
            </a>';     
            })
            
            ->rawColumns(['actions',"accred_prgrms","from", "to","program", "accred_stat", "cert1", "cert2", "cert3","visit_date"])
            ->make(true);
    }

    //view accredited programs per school
    public function accredited_programs($id){
        $school = School::where('id', $id)->first();
        return view('accreditation::accredited-programs', compact('school'));
    }
    public function viewPacucoaReport($id){

        $file = PrgrmAccred::where('id', $id)->first(); 
        $file_path = public_path('uploads/'.$file->pacucoa_cert);
 
 
        return response()->file($file_path);
    }
    public function accred_status(){
        return view('accreditation::accred-status');
    }
    public function accred_stat_dtb(){
        $status = AccredStat::orderByRaw(
            "CASE WHEN accred_status = 'Orientation' THEN 2 
            WHEN accred_status = 'Candidate Status' THEN 1 END DESC"
            
        )->orderBy('accred_status', 'Asc')->get();
         return DataTables::of($status)
            ->addColumn('actions', function($status) {
                    return '
                        <button class="btn btn-secondary btn-sm edit" statusid="'.$status->id.'"><i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm destroy" statusid="'.$status->id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
            })
            
            ->rawColumns(['actions','tbcount'])
            ->make(true);
    }


    // add Accreditation
    public function addStatus(Request $request){
          $accred = AccredStat::all();
          $success="";
        foreach($accred as $ac){
            if($ac->accred_status == $request->accredStatus){
                $success = false;
                $message = "Duplicate entry!";
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
            $status = new AccredStat;
            $status->accred_status = $request->accredStatus;
            $status->save();
            
            if (! $status->save()) {
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

    public function deleteStatus(Request $request)
    {
        $status = AccredStat::find($request->id);
        $status->delete();

        
    }
    public function editStatus(Request $request)
    {
        $status = AccredStat::find($request->id);
        echo '<label><label><span class="text-danger"> * </span></label>Status Name</label> <input type="text" class="form-control" name="statusName" required value="'.$status->accred_status.'"></input>

            <input type="hidden" name="sid" value="'.$request->id.'"></input>';

        
    }
    public function updateStatus(Request $request)
    {
        $status = AccredStat::find($request->sid);
        $status->accred_status = $request->statusName;
        $status->save();

            if (! $status->save()) {
                throw new Exception('Error in saving data.');
            } else {
                $success = true;
                $message = "Successfuly Updated!";
            }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }


//reports

    //View report
    public function accredReport(){
        $accreditations = PrgrmAccred::all()->sortByDesc('from');
        $programs = AcadPrgrm::all();
        $schools = School::all();
        $accredStats = AccredStat::all();


        return view('accreditation::accreditation-report', compact('accreditations', 'schools', 'accredStats', 'programs'));
        
    }

    //View history report
    public function viewProgramHistory(){
        $accreditations = PrgrmAccred::all();
        $programs = AcadPrgrm::all();
        $schools = School::all();
        $accredStats = AccredStat::all();


        return view('accreditation::history-reports', compact('accreditations', 'schools', 'accredStats', 'programs'));
        
    }


    //report datatables

    //Program Datatables
    public function program_report_dtb(){

   
        $programs = PrgrmAccred::join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
        ->join('schools', 'acad_prgrms.school_id', 'schools.id')
        ->where('current', 'yes');
          
        $sid = auth()->user()->school_id;
        if(!auth()->user()->hasRole('admin')){
            $programs->where('schools.id',$sid);
        }
        $programs->get();  
          
         return DataTables::of($programs)
            ->addColumn('school', function($programs) {
                return $programs->acadPrgrm->school->school_code;
            })
            ->addColumn('program', function($programs) {
                return $programs->acadPrgrm->acad_prog_code;
            })
            ->addColumn('accred_stat', function($programs) {
                    return $programs->accredStat->accred_status;
            })
            ->addColumn('validity', function($programs) {
                $dateValue_from = $programs->from;
                $dateValue = $programs->to;
                //display in words
                $time_from=strtotime($dateValue_from);
                $month_from=date("M",$time_from);
                $year_from=date("Y",$time_from);

                //display in words
                $time=strtotime($dateValue);
                $month=date("M",$time);
                $year=date("Y",$time);

                return $month_from.' '.$year_from.' - '.$month.' '.$year;
            })
            ->addColumn('visit_date', function($programs) {
                if($programs->visit_date_to){
                    return $programs->visit_date_from.' - '.$programs->visit_date_to;
                }else{
                    return $programs->visit_date_from;
                }
            })
            ->addColumn('visit_date_from', function($programs) {
                if($programs->visit_date_from){
                     $from = date('M. d, Y', strtotime($programs->visit_date_from));
                    return $from;
                }
            })
            ->addColumn('visit_date_to', function($programs) {
                if($programs->visit_date_from){
                     $to = date('M. d, Y', strtotime($programs->visit_date_from));
                    return $to;
                }
            })
            ->addColumn('from', function($programs) {
                if($programs->from){
                     $from = date('M Y', strtotime($programs->from));
                    return $from;
                }
            })
            ->addColumn('to', function($programs) {
                if($programs->to){
                     $to = date('M Y', strtotime($programs->to));
                    return $to;
                }
            })
            
            
            ->rawColumns(["program", "accred_stat", "school", 'validity', 'visit_date', 'visit_date_from', 'visit_date_to', 'from', 'to'])
            ->make(true);
    }
//Program Datatables
    public function program_history_report_dtb(){

        $programs = PrgrmAccred::join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
        ->join('schools', 'acad_prgrms.school_id', 'schools.id');

        $sid = auth()->user()->school_id;
        if(!auth()->user()->hasRole('admin')){
            $programs->where('schools.id',$sid);
        }
          $programs->get(); 
         return DataTables::of($programs)
            ->addColumn('school', function($programs) {
                return $programs->acadPrgrm->school->school_code;
            })
            ->addColumn('program', function($programs) {
                return $programs->acadPrgrm->acad_prog_code;
            })
            ->addColumn('accred_stat', function($programs) {
                    return $programs->accredStat->accred_status;
            })
            ->addColumn('validity', function($programs) {
                $dateValue_from = $programs->from;
                $dateValue = $programs->to;
                //display in words
                $time_from=strtotime($dateValue_from);
                $month_from=date("M",$time_from);
                $year_from=date("Y",$time_from);

                //display in words
                $time=strtotime($dateValue);
                $month=date("M",$time);
                $year=date("Y",$time);

                return $month_from.' '.$year_from.' - '.$month.' '.$year;
            })
            ->addColumn('visit_date', function($programs) {
                if($programs->visit_date_to){
                    return $programs->visit_date_from.' - '.$programs->visit_date_to;
                }else{
                    return $programs->visit_date_from;
                }
            })
             ->addColumn('visit_date_from', function($programs) {
                if($programs->visit_date_from){
                     $from = date('M. d, Y', strtotime($programs->visit_date_from));
                    return $from;
                }
            })
            ->addColumn('visit_date_from', function($programs) {
                if($programs->visit_date_from){
                     $from = date('M. d, Y', strtotime($programs->visit_date_from));
                    return $from;
                }
            })
            ->addColumn('visit_date_to', function($programs) {
                if($programs->visit_date_from){
                     $to = date('M. d, Y', strtotime($programs->visit_date_from));
                    return $to;
                }
            })
            ->addColumn('from', function($programs) {
                if($programs->from){
                     $from = date('M. d, Y', strtotime($programs->from));
                    return $from;
                }
            })
            ->addColumn('to', function($programs) {
                if($programs->to){
                     $to = date('M. d, Y', strtotime($programs->to));
                    return $to;
                }
            })
            
            
            ->rawColumns(["program", "accred_stat", "school", 'validity', 'visit_date', 'visit_date_from','visit_date_to','from','to'])
            ->make(true);
    }

    
    public function filterReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $school = $request->select1;
        //level
        $accredStatus = $request->select2;

        $expiry = $request->accredStat;
        $min = $request->min;
        $max = $request->max;
        $visitYear = $request->visitYear;

        $queryBuilder = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->join('accred_stats', 'accred_stats.id', 'prgrm_accreds.accred_stat_id')
            ;
            $sid = auth()->user()->school_id;
            if(!auth()->user()->hasRole('admin')){
                $queryBuilder->where('schools.id', $sid);
            }
            if(!$request->reportType == 'history'){
                 $queryBuilder =$queryBuilder->where('current', 'yes');
                
            }
            if($school){
                $queryBuilder =$queryBuilder->where('schools.school_code', $school);
            }
            if($accredStatus){
                $queryBuilder =$queryBuilder->where('accred_stats.accred_status', $accredStatus);
            }
            
            if($min != 'All' && $max !='All'){
                $queryBuilder = $queryBuilder->where(function ($queryBuilder) use($min, $max){
                    $queryBuilder->whereYear('from', '>=', $min)
                        ->whereYear('to', '<=', $max);
                });
            }

            if($expiry == 'Active'){
                $queryBuilder = $queryBuilder->where('to','>=', date('Y-m-d'));

            }
            if($expiry == 'Expired'){
                $queryBuilder = $queryBuilder->where('to','<=', date('Y-m-d'));

            }
            if($visitYear){
                $queryBuilder = $queryBuilder->whereBetween('visit_date_from', 
                                    [$visitYear.'-01-01', $visitYear.'-12-31']);

            }

            $queryBuilder = $queryBuilder->orderBy('from','asc');
            $queryBuilder = $queryBuilder->get();
      

        $pdf = PDF::loadView('accreditation::reports.accreditation-report', compact('queryBuilder', 'accredStatus', 'expiry', 'min', 'max', 'school', 'visitYear','department'));

        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('Level of Accreditation.pdf'); 
        //return $pdf->download('customers.pdf');

       //
         // return view('accreditation::reports.accreditation-report', compact('queryBuilder', 'accredStatus', 'expiry', 'min', 'max', 'school', 'visitYear','department'));
    }
    public function acadprogReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $school = $request->select1;
        if($school)
            $list = School::where('school_code',$school)->first();
        else
            $list = School::where('school_name','like','%School%')->orderBy('school_name')->get();
  
        $queryBuilder = AcadPrgrm::join('schools','schools.id','acad_prgrms.school_id');

        if($school)
        $queryBuilder = $queryBuilder->where('school_id',$list->id);

        $queryBuilder = $queryBuilder->get();

        $pdf = PDF::loadView('accreditation::reports.acadprog-report', compact('queryBuilder', 'list','department','school'));

        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf'); 
    }
    public function deleteProg(Request $request){
        $accred = PrgrmAccred::find($request->id);
        $accred->archived = 1;
        $accred->save();
        
        return redirect()->back();
    }

    //delete certificates
    public function deleteCert(Request $request){
        $type = $request->type;

        $programs = PrgrmAccred::where('id', $request->fileId)->first();

        if($type == 'pc'){
            File::delete(public_path('uploads').'/'.$programs->pacucoa_cert);
  
            $programs->pacucoa_cert = '';

        }else if($type == 'fc'){
            File::delete(public_path('uploads').'/'.$programs->faap_cert);
            $programs->faap_cert ='';
        }
        else if($type == 'pr'){

            File::delete(public_path('uploads').'/'.$programs->pacucoa_report);
            $programs->pacucoa_report='';
        }
        
        $programs->save();
        Session::flash('red', 'Record Deleted!'); 
    }

    public function addFile(Request $request){

        $programs = PrgrmAccred::where('id', $request->id)->first();


        $faap_cert_fileName='';
        $pacucoa_cert_fileName='';
        $pacucoa_report_fileName='';

            $request->validate([
            'faap_cert' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'pacucoa_cert' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'pacucoa_report' => 'nullable|mimes:jpeg,jpg,png,pdf',
            ]);
      
        if($request->hasFile('faap_cert')){
            
            $faap_cert_fileName = 'faap_cert_'.time().'.'.request()->faap_cert->getClientOriginalExtension();  
       
            request()->faap_cert->move(public_path('uploads'), $faap_cert_fileName);

             $programs->faap_cert = $faap_cert_fileName;
        }
        if($request->hasFile('pacucoa_report')){
            
            $pacucoa_report_fileName = 'pacucoa_report_'.time().'.'.request()->pacucoa_report->getClientOriginalExtension();  
       
            request()->pacucoa_report->move(public_path('uploads'), $pacucoa_report_fileName);

            $programs->pacucoa_report = $pacucoa_report_fileName;
        }
        if($request->hasFile('pacucoa_cert')){
            
            $pacucoa_cert_fileName = 'pacucoa_cert_'.time().'.'.request()->pacucoa_cert->getClientOriginalExtension();  
       
            request()->pacucoa_cert->move(public_path('uploads'), $pacucoa_cert_fileName);

            $programs->pacucoa_cert = $pacucoa_cert_fileName;
        }

        $programs->save();
        Session::flash('message', 'File Added!'); 

        return back();
    }

    // School
    public function viewSchool(){
        return view('accreditation::school-index');

    }
    public function academic_programs(){
        $school = School::where('school_name', 'like', 'School%')
        ->orWhere('school_name', 'like', '%School')
        ->orderBy('school_name','asc')
        ->get();
        return view('accreditation::acadprog-details', compact('school'));
    }

    public function school_dept_dtb(){
        $school = School::all()->sortByDesc('school_name');   
         return DataTables::of($school)
            ->addColumn('actions', function($school) {
                
                if (auth()->user()->hasPermission('edit-school','delete-school')) {
                    return '
                        <button class="btn btn-secondary btn-sm edit" title="Edit" schoolid="'.$school->id.'"><i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" schoolid="'.$school->id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
                }else{
                    return '
                    <button class="btn btn-secondary btn-sm edit" title="Edit" schoolid="'.$school->id.'"><i class="fa fa-edit"></i>
                    </button>';
                }
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function acad_prog_dtb(){
        $school = School::where('school_name', 'like', 'School%')
        ->orWhere('school_name', 'like', '%High School')->orderBy('school_name','asc')->get(); 
         return DataTables::of($school)
           ->addColumn('actions', function($school) {
                return '<a class="btn bg-ub-red btn-sm" href="'.route("academic_programs").'">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                              <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </a>';
        })
        ->rawColumns(["actions"])
        ->make(true);
    }
}