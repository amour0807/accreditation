<?php

namespace Modules\Award\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\AccredStat;
use Modules\Accreditation\Entities\PrgrmAccred;
use Modules\Award\Entities\Award;
use Modules\Award\Entities\InstAward;
use Modules\Accreditation\Entities\School;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use PDF;
use PdfReport;
use \Carbon\Carbon;
use Session;


class AdminAwardController extends Controller
{
    public function instAward()
    {
        $award = InstAward::all()->unique('award')->sortBy('award');
        // $instAward = DB::table('inst_award')->get();
        return view('award::instAward',compact('award'));
    }

    public function award_dtb($id){
        $awards = Award::join('acad_prgrms', 'acad_prgrms.id', 'awards.acad_prgram_id')
        ->join('schools', 'schools.id', 'acad_prgrms.school_id')
        ->select('*','awards.id as a_id')
        ->orderBy('awards.date_awarded','desc')
        ->get();   
         return DataTables::of($awards)
         ->addColumn('date_awarded', function($awards) {
            if(($awards->date_awarded) != "")
                $datea = date('M. d, Y', strtotime($awards->date_awarded));
            else
                $datea = "";
            return $datea;
        })
        ->addColumn('actions', function($awards) {
                    return '
                        <button class="btn btn-secondary btn-sm edit" title="Edit" awardid="'.$awards->a_id.'"><i class="fa  fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" awardid="'.$awards->a_id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
            })
            
            ->rawColumns(['actions','date_awarded'])
            ->make(true);
    }

    public function instAwardEdit($id){

        $instAward = InstAward::where('id', $id)->first();

        return view('award::instaward-edit', compact('instAward'));
    }

    public function instaward_dtb($id){
        $instAward = DB::table('inst_award')->orderBy('date_issued','desc')->get();

         return DataTables::of($instAward)
         ->addColumn('dfrom', function($instAward) {
            $dateValue_from = $instAward->from;
            $dateValue = $instAward->to;
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
        ->addColumn('date_issued', function($instAward) {
            if(($instAward->date_issued) != "")
                $to = date('M. d, Y', strtotime($instAward->date_issued));
            else
                $to = "";
            return $to;
        })
         ->addColumn('from', function($instAward) {
            if(($instAward->from) != "")
                $from = date('M. d, Y', strtotime($instAward->from));
            else
                $from = "";
            return $from;
        })
         ->addColumn('to', function($instAward) {
            if(($instAward->from) != "")
                $to = date('M. d, Y', strtotime($instAward->to));
            else
                $to = "";
            return $to;
        })
        ->addColumn('dsupporting_doc', function($instAward) {
            if(empty($instAward->supporting_doc)){
                return 'None';
            }else{
                return '<a target="_blank" href="'.asset('certificates/'.$instAward->supporting_doc).'">View</a>';
            }
        })
        ->addColumn('actions', function($instAward) {
            if (auth()->user()->hasPermission('edit-instaward','delete-instaward')) {
                return '
                    <a class="btn btn-info btn-sm" href="'.route("instAwardEdit", $instAward->id).'"> <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" instAwardID="'.$instAward->id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
            }
            })
        
            
            ->rawColumns(['actions','dfrom','dsupporting_doc','date_issued'])
            ->make(true);
    }
     public function deleteInstAward(Request $request){
        $instAward = InstAward::find($request->id);
        $instAward->delete();
       
    }

    public function updateInstAward(Request $request){
       
        $instaward = InstAward::find($request->awardID);
        $instaward->award = $request->award;
        $instaward->scope = $request->scope;
        $instaward->date_issued = $request->date_issued;
        $instaward->from = $request->from;
        $instaward->to = $request->to;
       // $instaward->venue = $request->venue;
        $instaward->award_giving_body = $request->award_gb;
        

         if($request->hasFile('award_cert_file')){
            
            $award_cert_fileName = 'award_cert_file'.time().'.'.request()->award_cert_file->getClientOriginalExtension();  
       
            request()->award_cert_file->move(public_path('certificates'), $award_cert_fileName);
            $instaward->supporting_doc = $award_cert_fileName;
        }else{
            $instaward->supporting_doc = $instaward->supporting_doc;
        }
        
        $instaward->save();

        return redirect()->route('instAward')->with('success', '');
    }
    public function deleteDocu(Request $request){
        $instAward = InstAward::where('id', $request->fileId)->first();

        $instAward->supporting_doc='';
        $instAward->save();

        Session::flash('red', 'Record Deleted!'); 
      
    }

    public function awardExcelReport(Request $request) {
        $department = School::where('id', auth()->user()->school_id)->first();
        $from = $request->from; //min
        $to = $request->to; //max
        $school = $request->select1;
        $scope = $request->select2;
        $category = $request->select3;

        $queryBuilder = DB::table('awards')
            ->join('acad_prgrms', 'acad_prgrms.id', 'awards.acad_prgram_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')->get();

        $timestamp = time();
        $filename = 'Export_excel_' . $timestamp . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        $isPrintHeader = false;
        foreach ($queryBuilder as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
        exit();
    }

    public function awardfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $from = $request->from; //min
        $to = $request->to; //max
        $school = $request->select1;
        $scope = $request->select2;
        $category = $request->select3;

        $queryBuilder = DB::table('awards')
            ->join('acad_prgrms', 'acad_prgrms.id', 'awards.acad_prgram_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id');
            
            if($from && $to){
                $queryBuilder = $queryBuilder->whereBetween('date_awarded', [$from, $to]);
            }

            if($school){
                $queryBuilder =$queryBuilder->where('schools.school_code', $school);
            }

            if($scope){
                $queryBuilder =$queryBuilder->where('awards.scope', $scope);
            }

            if($category){
                $queryBuilder =$queryBuilder->where('awards.category', $category);
            }

            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('award::reports.awards-report', compact('queryBuilder', 'school', 'scope', 'from', 'to', 'category', 'department') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
    // return view('award::reports.awards-report', compact('queryBuilder', 'school', 'scope', 'from', 'to', 'category', 'department') );
    }

    public function instawardfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $instAward = DB::table('inst_award')->get();
        $from = $request->min; //min
        $to = $request->max; //max
        $award = $request->award1;
        $scope = $request->scope1;

        $queryBuilder = DB::table('inst_award');
            
        if($from != 'All' && $to != 'All'){
            $queryBuilder = $queryBuilder->whereYear('from', $from)
            ->where(function ($queryBuilder) use($from, $to){
                $queryBuilder->whereYear('from', '>=', $from)
                    ->whereYear('to', '<=', $to);
            });
        }

            if($award != 'All'){
                $queryBuilder =$queryBuilder->where('inst_award.award', $award);
            }
            if($scope != 'All'){
                $queryBuilder =$queryBuilder->where('inst_award.scope', $scope);
            }

            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('award::reports.instawards-report', compact('queryBuilder', 'instAward', 'award', 'department', 'from', 'to','scope') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
     //return view('award::reports.instawards-report', compact('queryBuilder', 'instAward', 'award', 'department', 'from', 'to','scope') );
    }

    public function addInstAward(Request $request){
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:10240',
             ]);
             $insaward = InstAward::all();
             $success="";
             foreach($insaward as $ac){
                 if($ac->award == $request->award){
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
             
             $supporting_doc_fileName = 'supporting_doc'.time().'.'.request()->supporting_doc->getClientOriginalExtension();  
        
             request()->supporting_doc->move(public_path('certificates'), $supporting_doc_fileName);
         }

         $instAward = new InstAward;
         $instAward->award = $request->award;
         $instAward->scope = $request->scope;
         $instAward->date_issued = $request->date_issued;
         $instAward->from = $request->from;
         $instAward->to = $request->to;
        // $instAward->venue = $request->venue;
         $instAward->award_giving_body = $request->award_gb;
         $instAward->supporting_doc = $supporting_doc_fileName;
 
         $instAward->save();
         if (! $instAward->save()) {
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

}
