<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\PartnerClassification;
use Modules\Partner\Entities\PartnerRenewal;
use Modules\Partner\Entities\PartnerNature;
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
    public function index(){
        $school = School::all();
        $program = AcadPrgrm::all();

        return view('partner::index', compact('school','program'));
    }

    public function partner_dtb(){
      
          $partner = Partner::orderBy('id','desc')->get();

         return DataTables::of($partner)
                ->addColumn('classification', function($partner) {
                    $classification = "";
                if($partner->classification == "School"){
                    $classification = Partner::join('partner_classifications','partner_classifications.partner_id', 'partners.id')
                    ->join('schools','schools.id', 'partner_classifications.school_id')
                    ->where('partners.id',$partner->id)
                    ->pluck('school_code')->unique();

                }elseif ($partner->classification == "Program"){
                    $classification = Partner::join('partner_classifications','partner_classifications.partner_id', 'partners.id')
                    ->join('acad_prgrms','acad_prgrms.id', 'partner_classifications.program_id')
                    ->where('partners.id',$partner->id)
                    ->pluck('acad_prog_code')->unique();
                }
                return $classification;
            })
                ->addColumn('nature', function($partner) {
                   
                    $nature = Partner::join('partner_nature','partner_nature.partner_id', 'partners.id')
                    ->where('partners.id',$partner->id)
                    ->pluck('nature')->unique();

                return $nature;
                })
                ->addColumn('from', function($partner) {
                    if(($partner->from) != "")
                        $from = date('M. d, Y', strtotime($partner->from));
                    else
                        $from = "";
                    return $from;
                })
                ->addColumn('to', function($partner) {
                    if(($partner->from) != "")
                        $to = date('M. d, Y', strtotime($partner->to));
                    else
                        $to = "";
                    return $to;
                })
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
                        </a>
                        <button class="btn btn-danger btn-sm destroy" partnerid="'.$partner->id.'"><i class="far fa-trash-alt"></i>
                        </button>
                        ';
            })
            
            ->rawColumns(['actions','supporting_doc','from','to','classification','nature'])
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
         $partner->from = $request->from;
         $partner->to = $request->to;
         $partner->status = "Active";
         $partner->supporting_doc = $supporting_doc_fileName;
         $partner->save();

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
        if($request->classification == "School"){
           $school = $request->schoolc;
        
            $N = count($school);
            for($i=0; $i < $N; $i++)
            {
                $partnerC = new PartnerClassification;
                 $var1 = $school[$i];
                 $partnerC->partner_id = $partner_id;
                 $partnerC->school_id = $var1;
                 $partnerC->renewal_id = $rid;
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
                 $programC->partner_id = $partner_id;
                 $programC->program_id = $var1;
                 $programC->renewal_id = $rid;
                 $programC->save();
            }
         }

         // saved to nature table
         $nature = $request->nature;
         $C = count($nature);
         for($i=0; $i < $C; $i++)
         {
              $partnernature = new PartnerNature;
              $var1 = $nature[$i];
              if($var1 != 'Others' && $var1 != ""){
                $partnernature->partner_id = $partner_id;
                $partnernature->nature = $var1;
                $partnernature->save();
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
        $partnerR = Partner::with('partner_nature')
        ->where('id', $id)->get();
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
    public function partnerfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $from = $request->mindate; //min
        $to = $request->maxdate; //max
        $partnerCS = PartnerClassification::join('schools', 'schools.id', 'partner_classifications.school_id')
        ->get();//for school partnership

        $queryBuilder = DB::table('partners')
        ->join('partner_classifications','partner_classifications.partner_id','partners.id');
            
            if($from && $to){
                $queryBuilder = $queryBuilder->whereBetween('to', [$from, $to]);
            }
            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('partner::reports.partnerList-report', compact('queryBuilder','from', 'to','department','partnerCS') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
    }
    public function updatePartner(Request $request){
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
    public function deletePartner(Request $request){
        $partner = Partner::find($request->id);
        $partner->delete();
       
    }  
}
