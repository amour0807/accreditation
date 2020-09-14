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

class AccreditationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        //Lvl 4
        $count4 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 8)
                ->count();
        $count3 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 7)
                ->count();
        $count2 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 6)
                ->orwhere('prgrm_accreds.accred_stat_id', 5)
                ->orwhere('prgrm_accreds.accred_stat_id', 4)
                ->count();

        $count1 = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('prgrm_accreds.accred_stat_id', 3)
                ->count();
      
        return view('accreditation::index', compact('count1', 'count2', 'count3' ,'count4'));
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
            ->count();
                return $count;
        })
        ->addColumn('lvl3', function($school) {
            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 7)
            ->where('schools.id',$school->id)
            ->count();
            return $count;
        })
        //editing here
        ->addColumn('lvl2', function($school) {

            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('schools.id',$school->id)
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
            ->count();
            return $count;
        })
        ->addColumn('orientation', function($school) {
            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 1)
            ->where('schools.id',$school->id)
            ->count();
            return $count;
        })
        ->addColumn('candidate_stat', function($school) {
            $count = DB::table('prgrm_accreds')
            ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('prgrm_accreds.accred_stat_id', 2)
            ->where('schools.id',$school->id)
            ->count();
            return $count;
        })
        ->addColumn('actions', function($school) {
                return '<a class="btn btn-primary btn-sm" href="'.route("accredited_programs" , $school->id).'">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                              <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </a>
                        <a class="btn btn-success btn-sm" href="'.route("accredited_programs" , $school->id).'">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        <a class="btn btn-danger btn-sm" href="'.route("accredited_programs" , $school->id).'">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
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
        ->get();    


          
         return DataTables::of($programs)
            ->addColumn('program', function($programs) {
                return $programs->acadPrgrm->acad_prog_code;
            })
            ->addColumn('accred_stat', function($programs) {
                    return $programs->accredStat->accred_status;
            })
            ->addColumn('actions', function($programs) {
                    return '<a class="btn btn-primary btn-sm" href="">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                              <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </a>
                        <a class="btn btn-success btn-sm" href="">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        <a class="btn btn-danger btn-sm" href="">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </a>';
            })
            
            ->rawColumns(["program", "accred_stat", "actions"])
            ->make(true);
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
                echo "<option vlaue='".$program->id."' >".$program->id."</option>";
            } 
        }else{
            echo "<option vlaue=''>No Academic Program Added yet</option>";
        }
        
        echo "</select>";


    }


    // add Accreditation
    public function addAccred(Request $request){
   
        DB::table('prgrm_accreds')->insert(
            [
            'accred_stat_id' => $request->accredStat, 
            'acad_prgrm_id' => $request->program,
            'visit_date' => $request->visit_date,
            'from' => $request->from,
            'to' => $request->to,
            'remarks' => $request->remarks
            ]
        );
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
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('accreditation::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('accreditation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('accreditation::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
