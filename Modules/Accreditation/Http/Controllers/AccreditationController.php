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
        // $school = AcadPrgrm::with(['prgrmAccred', 'school'])->first();
        // dd($school->school);


      
        return view('accreditation::index');
    }

    // School datatable
    public function school_dtb(){
        $school = School::all();

        $accredPrgrms = PrgrmAccred::with(['acadPrgrm', 'acadPrgrm.school'])->get();
             
         return DataTables::of($school)
            ->addColumn('school', function($school) {
                return '<a href="#">'.$school->school_code.'</a>';
            })
            ->addColumn('accred_prgrms', function($school) {
                $countAccredprgrams = AcadPrgrm::
                where('school_id', $school->id)->
                count();
                    return $countAccredprgrams;
            })
            ->addColumn('lvl4', function($school) {
                $countAccredprgrams = AcadPrgrm::
                where('school_id', $school->id)->
                count();
                    return $countAccredprgrams;
            })
            ->addColumn('lvl3', function($school) {
                $countAccredprgrams = AcadPrgrm::
                where('school_id', $school->id)->
                count();
                    return $countAccredprgrams;
            })
            //editing here
            ->addColumn('lvl2', function($school) {

                // $all = PrgrmAccred::
                //     with(['acadPrgrm', 'acadPrgrm.school'])
                //     ->get();
                // $count = PrgrmAccred::
                //     where('')
                //     ->count();

                $count = DB::table('prgrm_accreds')
                ->join('acad_prgrms', 'acad_prgrms.id', 'prgrm_accreds.acad_prgrm_id')
                ->join('schools', 'schools.id', 'acad_prgrms.school_id')
                ->where('schools.id',$school->id)
                ->where(function ($query) {
                    $query->where('prgrm_accreds.accred_status_id', 4)
                        ->orWhere('prgrm_accreds.accred_status_id', 5)
                        ->orWhere('prgrm_accreds.accred_status_id', 6);
                })

                
                ->count();
                    return $count;
            })
                // $a = AcadPrgrm::with()->find();
                // $countAccredprgrams = PrgrmAccred::
                // with('acadPrgrm')->
                // where('acad_prgrms.school_id', $school->id)
                // ->where(function ($query) {
                //     $query->where('accred_status_id', '=', 4)
                //           ->orWhere('accred_status_id', '=', 5)
                //           ->orWhere('accred_status_id', '=', 6);
                // })
                // ->count();
                    // return $countAccredprgrams;
            // })
            ->addColumn('lvl1', function($school) {
                $countAccredprgrams = AcadPrgrm::
                where('school_id', $school->id)->
                count();
                    return $countAccredprgrams;
            })
            ->addColumn('orientation', function($school) {
                $countAccredprgrams = AcadPrgrm::
                where('school_id', $school->id)->
                count();
                    return $countAccredprgrams;
            })
            ->addColumn('candidate_stat', function($school) {
                $countAccredprgrams = AcadPrgrm::
                where('school_id', $school->id)->
                count();
                    return $countAccredprgrams;
            })
            ->rawColumns(["school", "accred_prgrms","lvl4","lvl3","lvl2","lvl1","orientation","candidate_stat"])
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
