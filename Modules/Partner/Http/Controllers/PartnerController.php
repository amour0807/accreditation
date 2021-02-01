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
use PDF;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        $partner = Partner::all()->sortBy('company_name');
        $school = School::all()->sortBy('school_code');
        $program = AcadPrgrm::all()->sortBy('acad_prog_code');
        $getExpired = Partner::whereNotNull('to')
        ->where('to', '<', date('Y-m-d'))
        ->get();
    
      foreach($getExpired as $xp){
        $update = Partner::find($xp->id);
        $update->status = "Inactive";
        $update->save();
      }

        return view('partner::index', compact('school','program','partner'));
    }

    public function partner_dtb(){
      
          $partner = PartnerRenewal::join('partners','partners.id','partner_renewal.partner_id')
          ->where('current', 'yes')
          ->orderBy('partners.from','desc')->get();
        
         return DataTables::of($partner)
                ->addColumn('classification', function($partner) {
                    $classification = "";
                if($partner->classification == "School"){
                    $classification = Partner::join('partner_classifications','partner_classifications.partner_id', 'partners.id')
                    ->join('schools','schools.id', 'partner_classifications.school_id')
                    ->where('partner_classifications.is_updated', 0)
                    ->where('partners.id',$partner->id)
                    ->pluck('school_code')->unique();

                }elseif ($partner->classification == "Program"){
                    $classification = Partner::join('partner_classifications','partner_classifications.partner_id', 'partners.id')
                    ->join('acad_prgrms','acad_prgrms.id', 'partner_classifications.program_id')
                    ->where('partner_classifications.is_updated', 0)
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
                    if(($partner->to) != "")
                        $to = date('M. d, Y', strtotime($partner->to));
                    else
                        $to = "";
                    return $to;
                })
             ->addColumn('supporting_doc', function($partner) {
                if(empty($partner->supporting_doc)){
                    return 'None';
                }else{
                    return '<a class="btn btn-sm" target="_blank" href="'.asset('moa/'.$partner->supporting_doc).'">View</a>';
                }
            })
            ->addColumn('actions', function($partner) {
                if(auth()->user()->hasPermission('delete-partner')){
                    return '
                        <a class="btn btn-secondary btn-sm" href="'.route("partnerDetail", $partner->id).'"><i class="fa fa-eye"></i>
                        </a> <a class="btn btn-secondary btn-sm" href="'.route("partnerHistory", $partner->id).'"><i class="fa fa-history" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-danger btn-sm destroy" partnerid="'.$partner->id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
                }else{
                    return '
                        <a class="btn btn-secondary btn-sm" href="'.route("partnerDetail", $partner->id).'"><i class="fa fa-eye"></i>
                        </a>
                        </a> <a class="btn btn-secondary btn-sm" href="'.route("partnerHistory", $partner->id).'"><i class="fa fa-history" aria-hidden="true"></i>
                        </a>
                        ';
                }
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
                return '<a class="btn btn-sm" target="_blank" href="'.asset('moa/'.$partnerRenewal->supporting_doc).'">View </a>';
            }
        })
            
            ->rawColumns(['from','to','supporting_doc'])
            ->make(true);
    }
    public function addPartner(Request $request){
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:2048',
                'nature' => 'required'
             ]);
             $check = Partner::all();
             $success="";
           foreach($check as $ac){
               if($ac->company_name == $request->partner){
                   $success = false;
                   $message = "Duplicate entry!";
                   return response()->json([
                       'success' => $success,
                       'message' => $message,
                   ]);
               }
           }
        $supporting_doc_fileName ="";
        if($request->hasFile('supporting_doc')){
             
             $supporting_doc_fileName = 'moa'.time().'.'.request()->supporting_doc->getClientOriginalExtension();  
        
             request()->supporting_doc->move(public_path('moa'), $supporting_doc_fileName);
         }
        $to = "";
         if($request->to != ""){
            $to = $request->to;
       }
         $partner = new Partner;
         $partner->company_name = $request->partner;
         $partner->scope = $request->scope;
         $partner->classification = $request->classification;
         $partner->from = $request->from;
         $partner->to = $to;
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
                 $partnerC->is_updated = 0;
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
                 $programC->is_updated = 0;
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
                $partnernature->is_updated = 0;
                $partnernature->save();
                }
        }
        if (! $partner->save()) {
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
         
         $remove = PartnerRenewal::where('current', 'yes')
         ->where('id', $id)->first();
         if($remove != null){
            $remove->current= '';
             $remove->save(); 
         }  
         $renew = new PartnerRenewal;
         $renew->partner_id = $id;
         $renew->from = $request->from;
         $renew->to = $request->to;
         $renew->supporting_doc = $supporting_doc_fileName;
         $renew->current = 'yes';
         $renew->save();

         $partner = Partner::find($id);
         $partner->from = $request->from;;
         $partner->to = $request->to;
         $partner->save();
         
         return back()->with('success_modal', 5);
     }

    public function partnerDetail($id){
        $partner= Partner::where('id', $id)->first();

        $partnerN = PartnerNature::where('is_updated', 0)
        ->where('partner_id', $id)->get();
        $natureList = PartnerNature::where('is_updated', 0)
        ->where('partner_id', $id)->pluck('nature')->unique();
        
        $partnerCP = PartnerClassification::join('partners', 'partners.id', 'partner_classifications.partner_id')
        ->join('acad_prgrms', 'acad_prgrms.id', 'partner_classifications.program_id')
        ->where('partner_classifications.is_updated',0)
        ->where('partners.id', $id)
        ->get();//for academic programs partnership

         $partnerCS = PartnerClassification::join('partners', 'partners.id', 'partner_classifications.partner_id')
        ->join('schools','schools.id','partner_classifications.school_id')
        ->where('partner_classifications.is_updated',0)
        ->where('partners.id', $id)
        ->get();//for school partnership
        
        $school = School::all()->sortBy('school_code');
        $program = AcadPrgrm::all()->sortBy('acad_prog_code');

        return view('partner::partner-detail', compact('partner','natureList','partnerN','partnerCP','partnerCS','school','program'));
    }
    public function partnerHistory($id){
        $partner = Partner::where('id', $id)->first();
        return view('partner::history', compact('partner'));

    }
    public function partnerfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $from = $request->from; 
        $to = $request->to; 
        $name = $request->partner1;
        $status = $request->status1;
        $partnerCS = PartnerClassification::join('schools', 'schools.id', 'partner_classifications.school_id')
        ->get();//for school partnership

        $queryBuilder = PartnerRenewal::join('partners','partners.id','partner_renewal.partner_id');
        
       // ->join('partner_classifications','partner_classifications.partner_id','partners.id');
            if($name != 'All'){
                $queryBuilder = $queryBuilder->where('company_name', $name);
            }
            if($status != 'All'){
                $queryBuilder = $queryBuilder->where('status', $status);
            } 
            if($from != 'All' && $to != 'All'){
                $queryBuilder = $queryBuilder->where(function ($queryBuilder) use($from, $to){
                    $queryBuilder->whereYear('partner_renewal.from', '>=', $from)
                        ->whereYear('partner_renewal.to', '<=', $to);
                });
            }
            $partnerList = $queryBuilder->pluck('company_name')->unique();
            $queryBuilder = $queryBuilder->orderBy('partner_renewal.from','desc')->get();
      $pdf = \PDF::loadView('partner::reports.partnerList-report', compact('queryBuilder','from', 'to','department','partnerCS','partnerList','name','status') );
            
        $pdf->save(storage_path().'_filename.pdf');

         return $pdf->stream('project_'.time().'.pdf');
     //return view('partner::reports.partnerList-report', compact('queryBuilder','from', 'to','department','partnerCS','partnerList','name','status') );
    }
    public function updatePartner(Request $request){
        $id = $request->partnerID;
        $to = "";
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:2048',
             'nature' => 'required'
             ]);
        if($request->to != ""){
             $to = $request->to;
        }
        $partner = Partner::find($id);
         $partner->company_name = $request->partner;
         $partner->scope = $request->scope;
         $partner->classification = $request->classification;
         $partner->from = $request->from;
         $partner->to = $to;
         $partner->status = "Active";
        if($request->hasFile('supporting_file')){
             
             $supporting_doc_fileName = 'moa'.time().'.'.request()->supporting_file->getClientOriginalExtension();  
        
             request()->supporting_file->move(public_path('moa'), $supporting_doc_fileName);
               $partner->supporting_doc = $supporting_doc_fileName;
        }else{
            $partner->supporting_doc = $partner->supporting_doc;
        }
        $partner->save();
       
         // save also to partner_classification Table
         $oldRenewalID = 0;
         if($request->classification == "School"){
            $oldSchool = PartnerClassification::where('partner_id', $id)
            ->get();
            foreach($oldSchool as $o){

                $oldSC = PartnerClassification::find($o->id);
                $oldSC->is_updated = 1;
                $oldSC->save();
               $oldRenewalID = $o->renewal_id;
            }

            $school = $request->schoolc;
         
             $N = count($school);
             for($i=0; $i < $N; $i++)
             {
                 $partnerC = new PartnerClassification;
                  $var1 = $school[$i];
                  $partnerC->partner_id = $id;
                  $partnerC->school_id = $var1;
                  $partnerC->renewal_id = $oldRenewalID;
                  $partnerC->is_updated = 0;
                  $partnerC->save();
             }
         }elseif($request->classification == "Program"){
            $oldProg = PartnerClassification::where('partner_id', $id)
            ->get();
            foreach($oldProg as $op){

                $oldSC = PartnerClassification::find($op->id);
                $oldSC->is_updated = 1;
                $oldSC->save();
               $oldRenewalID = $op->renewal_id;
            }

            $acad = $request->programc;
         
             $N = count($acad);
             for($i=0; $i < $N; $i++)
             {
                 $partnerC = new PartnerClassification;
                  $var1 = $acad[$i];
                  $partnerC->partner_id = $id;
                  $partnerC->program_id = $var1;
                  $partnerC->renewal_id = $oldRenewalID;
                  $partnerC->is_updated = 0;
                  $partnerC->save();
             }
         }

         // update to nature table
         //set the old nature to is_updated
         $oldNature = PartnerNature::where('partner_id', $id)->get();
         foreach($oldNature as $on){

             $oldN = PartnerNature::find($on->id);
             $oldN->is_updated = 1;
             $oldN->save();
         }

         $nature = $request->nature;
         $C = count($nature);
         for($i=0; $i < $C; $i++)
         {
              $partnernature = new PartnerNature;
              $var1 = $nature[$i];
              if($var1 != 'Others' && $var1 != ""){
                $partnernature->partner_id = $id;
                $partnernature->nature = $var1;
                $partnernature->is_updated = 0;
                $partnernature->save();
                }
        }

        return redirect()->route('partnerDetail',$id)->with('success', 'Record Updated');
    }
    public function deletePartner(Request $request){
        $classification = PartnerClassification::where('partner_id',$request->id);
        $classification->delete();

        $renewal = PartnerRenewal::where('partner_id',$request->id);
        $renewal->delete();

        $nature = PartnerNature::where('partner_id',$request->id);
        $nature->delete();

        $partner = Partner::find($request->id);
        $partner->delete();
       
    }  
}
