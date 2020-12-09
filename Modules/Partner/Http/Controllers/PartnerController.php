<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\PartnerClassification;
use Modules\Partner\Entities\Partner;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use PDF;
use PdfReport;
use \Carbon\Carbon;
use Session;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $school = School::all();
        $program = AcadPrgrm::all();
        return view('partner::index', compact('school','program'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function partner_dtb(){
      
          $partner = Partner::all();

         return DataTables::of($partner)
            ->addColumn('actions', function($partner) {
                    return '
                        <a class="btn btn-secondary btn-sm" href="'.route("partnerEdit", $partner->id).'"><i class="far fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-sm destroy" partnerid="'.$partner->id.'"><i class="far fa-trash-alt"></i>
                        </button>
                        ';
            })
            
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function addPartner(Request $request){
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:2048',
             ]);

        $supporting_doc_fileName ="";
        if($request->hasFile('supporting_doc')){
             
             $supporting_doc_fileName = 'moa'.time().'.'.request()->supporting_doc->getClientOriginalExtension();  
        
             request()->supporting_doc->move(public_path('moa'), $supporting_doc_fileName);
         }

         $partner = new Partner;
         $partner->company_name = $request->partner;
         $partner->scope = $request->scope;
         $partner->classification = $request->classification;
         $partner->nature_partnership = $request->nature;
         $partner->from = $request->from;
         $partner->to = $request->to;
         $partner->status = $request->status;
         $partner->supporting_doc = $supporting_doc_fileName;
         $partner->save();

        $id = $partner->id;

        if($request->classification == "School"){
           $school = $request->schoolc;

            $N = count($school);
            for($i=0; $i < $N; $i++)
            {
                $partnerC = new PartnerClassification;
                 $var1 = $school[$i];
                 $partnerC->partner_id = $id;
                 $partnerC->school_id = $var1;
                 $partnerC->save();
            }
        }
         if($request->classification == "Program"){
             $program = $request->programc;

            $N = count($program);
            for($i=0; $i < $N; $i++)
            {
                $programC = new PartnerClassification;
                 $var1 = $program[$i];
                 $programC->partner_id = $id;
                 $programC->program_id = $var1;
                 $programC->save();
            }
         }

         return back()->with('success_modal', 5);
     }

     public function partnerEdit($id){
        $partner = Partner::where('id', $id)->get();
        $partnerC = PartnerClassification::all();
        $school = School::all();
        $program = AcadPrgrm::all();

        return view('partner::partner-edit', compact('partner','partnerC','school','program'));
    }

      public function deletePartner(Request $request)
    {
        $partner = Partner::find($request->id);
        $partner->delete();
       
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
        return view('partner::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('partner::edit');
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
