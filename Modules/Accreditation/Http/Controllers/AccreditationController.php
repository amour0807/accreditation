<?php

namespace Modules\Accreditation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\AccredStat;
use Modules\Accreditation\Entities\PrgrmAccred;
use Modules\Accreditation\Entities\School;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Storage;

use App\Models\File;

class AccreditationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

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
      
        return view('accreditation::index', compact('count1', 'count2', 'count3' ,'count4', 'count5', 'count6'));
    }

    // School datatable
    public function school_dtb(){
        $school = School::all();
             
        return DataTables::of($school)
        ->addColumn('school', function($school) {
            return $school->school_code;
        })
        ->addColumn('accred_prgrms', function($school) {
            $countAccredprgrams = AcadPrgrm::
            where('school_id', $school->id)->
            count();
                return $countAccredprgrams;
        })
        ->addColumn('lvl4', function($school) {
             $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 8)
            ->where('schools.id', $school->id)
            ->where('current', 'yes')

            ->count();
                return $count;
        })
        ->addColumn('lvl3', function($school) {
            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 7)
            ->where('schools.id',$school->id)
            ->where('current', 'yes')
            ->count();
            return $count;
        })
        //editing here
        ->addColumn('lvl2', function($school) {

            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('schools.id',$school->id)
            ->where('current', 'yes')
            ->where(function ($query) {
                $query->where('prgrm_accreds.accred_stat_id', 4)
                    ->orWhere('prgrm_accreds.accred_stat_id', 5)
                    ->orWhere('prgrm_accreds.accred_stat_id', 6);
            })
            ->count();
                return $count;
        })
           
        ->addColumn('lvl1', function($school) {
            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 3)
            ->where('schools.id',$school->id)
            ->where('current', 'yes')
            ->count();
            return $count;
        })
        ->addColumn('orientation', function($school) {
            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 1)
            ->where('schools.id',$school->id)
            ->where('current', 'yes')
            ->count();
            return $count;
        })
        ->addColumn('candidate_stat', function($school) {
            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 2)
            ->where('schools.id',$school->id)
            ->where('current', 'yes')
            ->count();
            return $count;
        })
        ->addColumn('actions', function($school) {
                return '<a class="btn bg-ub-red btn-sm" href="'.route("accredited_programs" , $school->id).'">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                              <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </a>';
        })
        ->rawColumns(["school", "accred_prgrms","lvl4","lvl3","lvl2","lvl1","orientation","candidate_stat", "actions"])
        ->make(true);
    }

    //Add school
    public function addSchoolForm(Request $request){

        DB::table('schools')->insert(
            [
            'school_name' => $request->school_name, 
            'school_code' => $request->school_code,
            ]
        );
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
                if(empty($programs->pacucoa_cert)){
                    return ' ';
                }else{
                    return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
</svg>';
                }
            })
            ->addColumn('cert2', function($programs) {
                if(empty($programs->pacucoa_cert)){
                    return ' ';
                }else{
                    return '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
</svg>';
                }
            })
            ->addColumn('cert3', function($programs) {
                if(empty($programs->pacucoa_report)){
                    return ' ';
                }else{
                    return '<svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
</svg>';
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
                    return '<a class="btn bg-ub-red btn-sm" href="'.route("accredDetails", $programs->a_id).'">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-secondary btn-sm" href="'.route("accredHistory", $programs->a_id).'"><i class="fa fa-history" aria-hidden="true"></i>
                        </a>
                        ';
            })
            
            ->rawColumns(['from', 'to',"program", "accred_stat", "actions", 'cert1', 'cert2', 'cert3','visit_date'])
            ->make(true);
    }

    public function accredDetails($id){
        $program = PrgrmAccred::where('id', $id)->first();

        return view('accreditation::accreditation-details', compact('program'));

    }
    public function accredEdit($id){
        $program = PrgrmAccred::where('acad_prgrm_id', $id)->first();
        $accredStats = AccredStat::all();

        return view('accreditation::accreditation-edit', compact('program', 'accredStats'));

    }
    public function accredHistory($id){
        $program = PrgrmAccred::where('acad_prgrm_id', $id)->first();

        return view('accreditation::history', compact('program'));

    }


    public function add_accred_form(){
        $schools = School::all();
        $accredStats = AccredStat::all();

        return view('accreditation::add-accreditation', compact('schools', 'accredStats'));

    }

    public function school_select(Request $request){
        $programs = AcadPrgrm::where('school_id', $request->id)->get();

        echo '<select class="form-control-sm form-control" name="program" required>
                <option disabled selected value> </option>';

        if ($programs->count() != 0){
            foreach ($programs as $program) {
                echo "<option value='".$program->id."' >".$program->id."</option>";
            } 
        }else{
            echo "<option vlaue=''>No Academic Program Added yet</option>";
        }
        
        echo "</select>";


    }


    // add Accreditation
    public function addAccred(Request $request){
        $faap_cert_fileName='';
        $pacucoa_cert_fileName='';

        $pacucoa_report_fileName='';
            $request->validate([
            'faap_cert' => 'nullable|mimes:pdf,xlx,csv|max:2048',
            'pacucoa_cert' => 'nullable|mimes:pdf,xlx,csv|max:2048',
            'pacucoa_report' => 'nullable|mimes:jpeg,png',

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
        $remove = PrgrmAccred::where('current', 'yes')->first();
        $remove->current= '';
        $remove->save();

        if($request->visit_date_to){
            DB::table('prgrm_accreds')->insert(
                [
                'accred_stat_id' => $request->accredStat, 
                'acad_prgrm_id' => $request->program,
                'from' => $request->from.'-01',
                'to' => $request->to.'-01',
                'visit_date_from' => $request->visit_date,
                'visit_date_to' => $request->visit_date_to,
                'faap_cert' => $faap_cert_fileName,
                'pacucoa_report' => $pacucoa_report_fileName,
                'pacucoa_cert' => $pacucoa_cert_fileName,
                'current' => 'yes',
                'remarks' => $request->remarks
                ]
            );
        }else{
            DB::table('prgrm_accreds')->insert(
                [
                'accred_stat_id' => $request->accredStat, 
                'acad_prgrm_id' => $request->program,
                'from' => $request->visit_date.'-01',
                'visit_date_from' => $request->visit_date,
                'visit_date_to' => $request->visit_date_to,
                'faap_cert' => $faap_cert_fileName,
                'pacucoa_report' => $pacucoa_report_fileName,
                'pacucoa_cert' => $pacucoa_cert_fileName,
                'current' => 'yes',

                'remarks' => $request->remarks
                ]
            );
        }

        return back()->with('error_code', 5);
    }

    //view accredited programs per school
    public function accredited_programs($id){
        $school = School::where('id', $id)->first();
        return view('accreditation::accredited-programs', compact('school'));
    }


    //View report
    public function accredReport(){
        return view('accreditation::accreditation-report');
        
    }

    //report datatables

    //Program Datatables
    public function program_report_dtb(){

   
        $programs = PrgrmAccred::join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
        ->join('schools', 'acad_prgrms.school_id', 'schools.id')
        ->where('current', 'yes')
        ->get();    


          
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
            
            
            ->rawColumns(["program", "accred_stat", "school"])
            ->make(true);
    }


    public function viewPacucoaReport($id){

        $file = PrgrmAccred::where('id', $id)->first(); 
        $file_path = public_path('uploads/'.$file->pacucoa_cert);
 
 
        return response()->file($file_path);
    }
}
