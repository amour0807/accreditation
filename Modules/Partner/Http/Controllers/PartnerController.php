<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\PartnerClassification;
<<<<<<< HEAD
=======
use Modules\Partner\Entities\PartnerRenewal;
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
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

<<<<<<< HEAD
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
=======
    public function partner_dtb(){
      
          $partner = Partner::orderBy('id','desc')->get();

         return DataTables::of($partner)
             ->addColumn('supporting_doc', function($partner) {
                if(empty($partner->supporting_doc)){
                    return 'None';
                }else{
                    return '<a class="btn btn-sm" target="_blank" href="'.asset('moa/'.$partner->supporting_doc).'">View Document</a>';
                }
            })
            ->addColumn('actions', function($partner) {
                    return '
                        <a class="btn btn-secondary btn-sm" href="'.route("partnerDetail", $partner->id).'"><i class="far fa-eye"></i>
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
                        </a>
                        <button class="btn btn-danger btn-sm destroy" partnerid="'.$partner->id.'"><i class="far fa-trash-alt"></i>
                        </button>
                        ';
            })
            
<<<<<<< HEAD
            ->rawColumns(['actions'])
=======
            ->rawColumns(['actions','supporting_doc'])
            ->make(true);
    }
    //history table for partner classification
    public function partner_history_dtb($id){

        $partnerRenewal = PartnerRenewal::where('partner_id', $id)->orderBy('id','desc');

         return DataTables::of($partnerRenewal)
          ->addColumn('from', function($partnerRenewal) {
            if(($partnerRenewal->from) != "")
                $from = date('M. d, Y', strtotime($partnerRenewal->from));
            else
                $from = "";
            return $from;
        })
         ->addColumn('to', function($partnerRenewal) {
            if(($partnerRenewal->from) != "")
                $to = date('M. d, Y', strtotime($partnerRenewal->to));
            else
                $to = "";
            return $to;
        })
         ->addColumn('supporting_doc', function($partnerRenewal) {
            if(empty($partnerRenewal->supporting_doc)){
                return 'None';
            }else{
                return '<a class="btn btn-sm" target="_blank" href="'.asset('moa/'.$partnerRenewal->supporting_doc).'">View Document</a>';
            }
        })
            
            ->rawColumns(['from','to','supporting_doc'])
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
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

<<<<<<< HEAD
        $id = $partner->id;

=======
         $partner_id = $partner->id;
         // save also to renewal_table
         $renewal = new PartnerRenewal;
         $renewal->partner_id = $partner_id;
         $renewal->from = $request->from;
         $renewal->to = $request->to;
         $renewal->supporting_doc = $supporting_doc_fileName;
         $renewal->save();

         $rid = $renewal->id;

        // save also to partner_classification Table
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
        if($request->classification == "School"){
           $school = $request->schoolc;

            $N = count($school);
            for($i=0; $i < $N; $i++)
            {
                $partnerC = new PartnerClassification;
                 $var1 = $school[$i];
<<<<<<< HEAD
                 $partnerC->partner_id = $id;
                 $partnerC->school_id = $var1;
=======
                 $partnerC->partner_id = $partner_id;
                 $partnerC->school_id = $var1;
                 $partnerC->renewal_id = $rid;
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
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
<<<<<<< HEAD
                 $programC->partner_id = $id;
                 $programC->program_id = $var1;
=======
                 $programC->partner_id = $partner_id;
                 $programC->program_id = $var1;
                 $programC->renewal_id = $rid;
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
                 $programC->save();
            }
         }

<<<<<<< HEAD
=======


>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
         return back()->with('success_modal', 5);
     }

     public function partnerEdit($id){
        $partner = Partner::where('id', $id)->get();
        $partnerC = PartnerClassification::all();
        $school = School::all();
        $program = AcadPrgrm::all();

        return view('partner::partner-edit', compact('partner','partnerC','school','program'));
    }
<<<<<<< HEAD

=======
    public function renewPartner(Request $request){
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:2048',
             ]);
        $id = $request->renew_partnerID;
        $supporting_doc_fileName ="";
        if($request->hasFile('supporting_file')){
             
             $supporting_doc_fileName = 'moa'.time().'.'.request()->supporting_file->getClientOriginalExtension();  
        
             request()->supporting_file->move(public_path('moa'), $supporting_doc_fileName);
         }

         $renew = new PartnerRenewal;
         $renew->partner_id = $id;
         $renew->from = $request->from;
         $renew->to = $request->to;
         $renew->supporting_doc = $supporting_doc_fileName;
         $renew->save();

         $partner = Partner::find($id);
         $partner->from = $request->from;;
         $partner->to = $request->to;
         $partner->save();
         
         return back()->with('success_modal', 5);
     }

    public function partnerDetail($id){
        $partnerR = Partner::where('id', $id)->get();
        $partnerCP = PartnerClassification::join('acad_prgrms', 'acad_prgrms.id', 'partner_classifications.program_id')
        ->where('partner_id', $id)
        ->get();//for academic programs partnership

         $partnerCS = PartnerClassification::join('schools', 'schools.id', 'partner_classifications.school_id')
        ->where('partner_id', $id)
        ->get();//for school partnership

        $school = School::all();
        $program = AcadPrgrm::all();

        return view('partner::partner-detail', compact('partnerR','partnerCP','partnerCS','school','program'));
    }

    public function updatePartner(Request $request)
    {
        $id = $request->partnerID;
          $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:2048',
             ]);

        
        $partner = Partner::find($id);
         $partner->company_name = $request->partner;
         $partner->scope = $request->scope;
         $partner->classification = $request->classification;
         $partner->nature_partnership = $request->nature;
         $partner->from = $request->from;
         $partner->to = $request->to;
         $partner->status = $request->status;
        if($request->hasFile('supporting_file')){
             
             $supporting_doc_fileName = 'moa'.time().'.'.request()->supporting_file->getClientOriginalExtension();  
        
             request()->supporting_file->move(public_path('moa'), $supporting_doc_fileName);
               $partner->supporting_doc = $supporting_doc_fileName;
        }else{
            $partner->supporting_doc = $partner->supporting_doc;
        }

        
        $partner->save();

        return redirect()->route('partnerDetail',$id)->with('success', 'Record Updated');
    }
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
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
