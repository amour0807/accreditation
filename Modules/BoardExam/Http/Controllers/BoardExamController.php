<?php

namespace Modules\BoardExam\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BoardExam\Entities\BoardExam;
use Modules\Accreditation\Entities\School;
use Modules\BoardExam\Entities\Topnotcher;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use PDF;
use PdfReport;
use \Carbon\Carbon;
use Session;


class BoardExamController extends Controller
{
   
    public function index(){
        return view('boardexam::index');
    }
   
    public function boardDetail($id){
        $board = BoardExam::where('id',$id)->first();
        $topnotcher = Topnotcher::where('boardexam_id',$id)->get();

        return view('boardexam::boardDetail',compact('board','topnotcher'));
    }
    public function boardHistory($licensure_exam){
        $exam = $licensure_exam;

        return view('boardexam::boardHistory',compact('exam'));
    }

    public function addBoardExam(Request $request){
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:2048',
             ]);

        $supporting_doc_fileName ="";
        if($request->hasFile('supporting_doc')){
             
             $supporting_doc_fileName = 'board'.time().'.'.request()->supporting_doc->getClientOriginalExtension();  
        
             request()->supporting_doc->move(public_path('board'), $supporting_doc_fileName);
         }

         $board = new BoardExam;
         $board->licensure_exam = $request->exam;
         $board->exam_date = $request->exam_date;
         $board->school_rank = $request->school_rank;
         $board->ftaker_passed = $request->fpassed;
         $board->ftaker_failed = $request->ffailed;
         $board->ftaker_cond = $request->fcon;
         $board->total_passed = $request->tpassed;
         $board->total_failed = $request->tfailed;
         $board->total_cond = $request->tcon;
         $board->type = $request->exam_type;
         $board->supporting_doc = $supporting_doc_fileName;
         $board->save();

         $id = $board->id;
         $topnotcher = new Topnotcher;
         if($topnotcher->name != ""){
           $top = $request->top;
           $rank = $request->rank;

            $N = count($top);
            for($i=0; $i < $N; $i++)
            {
                
                 $var1 = $top[$i];
                 $var2 = $rank[$i];
                 $topnotcher->boardexam_id = $id;
                 $topnotcher->name = $var1;
                 $topnotcher->rank = $var2;
                 $topnotcher->save();
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
    public function boardexam_dtb(){
      
          $board = BoardExam::orderBy('id','desc')->get();
          $topnotcher = Topnotcher::all();

         return DataTables::of($board)
             ->addColumn('supporting_doc', function($board) {
                if(empty($board->supporting_doc)){
                    return 'None';
                }else{
                    return '<a class="btn btn-sm" target="_blank" href="'.asset('board/'.$board->supporting_doc).'">View Document</a>';
                }
            })
             ->addColumn('topnotcher', function($board) {
                $countTopnotcher = Topnotcher::
                where('boardexam_id', $board->id)->
                count();
                return $countTopnotcher;
            })
            ->addColumn('exam_date', function($programs) {
                if($programs->exam_date){
                     $to = date('M. d, Y', strtotime($programs->exam_date));
                    return $to;
                }
            })
            ->addColumn('actions', function($board) {
                    return '
                        <a class="btn btn-secondary btn-sm" href="'.route("boardDetail", $board->id).'"><i class="far fa-eye"></i>
                        </a>
                        <a class="btn btn-secondary btn-sm" href="'.route("boardHistory", $board->licensure_exam).'"><i class="fa fa-history" aria-hidden="true"></i>
                        </a>
                        ';
            })
            
            ->rawColumns(['actions','supporting_doc','exam_date'])
            ->make(true);
    }
    public function boardHistory_dtb(){
      
          $board = BoardExam::where('licensure_exam','Architects')->get();
          $topnotcher = Topnotcher::all();

         return DataTables::of($board)
             ->addColumn('topnotcher', function($board) {
                $countTopnotcher = Topnotcher::
                where('boardexam_id', $board->id)->
                count();
                return $countTopnotcher;
            })
            ->addColumn('exam_date', function($board) {
                if($board->exam_date){
                     $to = date('M. d, Y', strtotime($board->exam_date));
                    return $to;
                }
            })
            ->addColumn('ftaker_total', function($board) {
                    $sum = $board->ftaker_passed+$board->ftaker_failed+$board->ftaker_cond;
                    return $sum;
               
            })
            ->addColumn('total_total', function($board) {
                     $sum = $board->total_passed+$board->total_failed+$board->total_cond;
                    return $sum;
               
            })
            ->addColumn('ftaker_percentage', function($board) {
                
                   $sum = $board->ftaker_passed+$board->ftaker_failed+$board->ftaker_cond;
                   $percent = ($board->ftaker_passed/$sum)*100;
                    return round($percent, 2).'%';
               
            })
            ->addColumn('overall_percentage', function($board) {
                
                  $sum = $board->total_passed+$board->total_failed+$board->total_cond;
                   $percent = ($board->total_passed/$sum)*100;
                    return round($percent, 2).'%';
               
            })
            ->addColumn('national_percent', function($board) {
                
                  $sum = 0;
                    return round($sum, 2).'%';
               
            })
            ->rawColumns(['exam_date','topnotcher','ftaker_total','total_total','national_percent'])
            ->make(true);
    }
    public function boardfilterReport(Request $request){
        $from = $request->from; //min
        $to = $request->to; //max
        $type = $request->select1;

        $queryBuilder = DB::table('board_exam');
            
            if($from && $to){
                $queryBuilder = $queryBuilder->whereBetween('exam_date', [$from, $to]);
            }

            if($type){
                $queryBuilder =$queryBuilder->where('boar_dexam.type', $type);
            }

            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('award::reports.instawards-report', compact('queryBuilder', 'instAward', 'award', 'department', 'from', 'to') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
    }
    public function bHistoryfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $exam = $request->licensure; //min
        $from = $request->mindate; //min
        $to = $request->maxdate; //max

        $queryBuilder = DB::table('board_exam');
            
            if($from && $to){
                $queryBuilder = $queryBuilder->whereBetween('exam_date', [$from, $to]);
            }
            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('boardexam::reports.history-report', compact('queryBuilder','from', 'to','department','exam') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
    }

    //topnotchers
     public function topnotchers(){
        return view('boardexam::topnotcher');
    }
     public function topnotcher_dtb(){     $topnotcher = Topnotcher::join('board_exam','board_exam.id','boardexam_id')->get();
          
         return DataTables::of($topnotcher)
         ->addColumn('exam_date', function($programs) {
                if($programs->exam_date){
                     $to = date('M. d, Y', strtotime($programs->exam_date));
                    return $to;
                }
            })
         ->rawColumns(['exam_date'])
         ->make(true);
    }
    public function topfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $exam = $request->select1; //min
        $rank = $request->select2;
        $from = $request->mindate; //min
        $to = $request->maxdate; //max

        $queryBuilder = DB::table('topnotchers')->join('board_exam','board_exam.id','boardexam_id');
            
            if($from && $to){
                $queryBuilder = $queryBuilder->whereBetween('exam_date', [$from, $to]);
            }
            if($exam){
                $queryBuilder = $queryBuilder->where('licensure_exam', $exam);
            }
            if($rank){
                $queryBuilder = $queryBuilder->where('rank', $rank);
            }
            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('boardexam::reports.topnotcher-report', compact('queryBuilder','from', 'to','department','exam','rank') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
    }
}
