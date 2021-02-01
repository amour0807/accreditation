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

use PDF;


class BoardExamController extends Controller
{
   
    public function index(){
        return view('boardexam::index');
    }
   
    public function boardDetail($id){
        $board = BoardExam::where('id',$id)->first();
        $topnotcher = Topnotcher::where('boardexam_id',$id)
        ->where('is_updated',0)->get();
        return view('boardexam::boardDetail',compact('board','topnotcher'));
    }
    public function boardEdit($id){
        $board = BoardExam::where('id',$id)->first();
        $topnotcher = Topnotcher::where('boardexam_id',$id)
        ->where('is_updated',0)->get();

        return view('boardexam::boardEdit',compact('board','topnotcher'));
    }
    public function boardHistory($licensure_exam){
        $exam = $licensure_exam;

        return view('boardexam::boardHistory',compact('exam'));
    }

    public function addBoardExam(Request $request){
        $request->validate([
            'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:10240',
            ]);

             $check = BoardExam::where('archived',0)->get();
             $success="";
           foreach($check as $ac){
               if($ac->licensure_exam == $request->exam && $ac->exam_month == $request->month && $ac->exam_year == $request->year){
                   return redirect()->back()->with('duplicate','');
               }
           }
         $board = new BoardExam;
         $board->licensure_exam = $request->exam;
         $board->exam_month = $request->month;
         $board->exam_year = $request->year;
         $board->school_rank = $request->school_rank;
         $board->ftaker_passed = $request->fpassed;
         $board->ftaker_failed = $request->ffailed;
         $board->ftaker_cond = $request->fcon;
         $board->total_passed = $request->tpassed;
         $board->total_failed = $request->tfailed;
         $board->total_cond = $request->tcon;
         $board->national_percent = $request->npasser;
         if($request->hasFile('supporting_doc')){
            
            $supporting_doc_fileName = 'board'.time().'.'.request()->supporting_doc->getClientOriginalExtension();  
       
            request()->supporting_doc->move(public_path('board'), $supporting_doc_fileName);
            $board->supporting_doc = $supporting_doc_fileName;
        }
         $board->archived = 0;
         $board->save();

         $id = $board->id;
         
           $top = $request->top;
           $rank = $request->rank;

            $N = count($top);
            
            for($i=0; $i < $N; $i++)
            {
                $var1 = $top[$i];
                $var2 = $rank[$i];
                if($var1 != "" || $var2 != ""){
                $topnotcher = new Topnotcher;
                 $topnotcher->boardexam_id = $id;
                 $topnotcher->name = $var1;
                 $topnotcher->rank = $var2;
                 $topnotcher->is_updated = 0;
                 $topnotcher->save();
                }
            }
            if ($board->save()) {
                return redirect()->back()->with('success','');
            } else {
                return redirect()->back()->with('error','');
            }
     }
    
     public function updateBoard(Request $request){
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:10240',
             ]);
             
             if($request->exam_to != null || $request->exam_to != ""){
                $to = $request->exam_to;
            }else
            $to = "";
         $board = BoardExam::find($request->boardID);
         $board->licensure_exam = $request->exam;
         $board->exam_month = $request->month;
         $board->exam_year = $request->year;
         $board->school_rank = $request->school_rank;
         $board->ftaker_passed = $request->fpassed;
         $board->ftaker_failed = $request->ffailed;
         $board->ftaker_cond = $request->fcon;
         $board->total_passed = $request->tpassed;
         $board->total_failed = $request->tfailed;
         $board->total_cond = $request->tcon;
         $board->national_percent = $request->npasser;
         if($request->hasFile('supporting_doc')){
            
            $supporting_doc_fileName = 'board'.time().'.'.request()->supporting_doc->getClientOriginalExtension();  
       
            request()->supporting_doc->move(public_path('board'), $supporting_doc_fileName);
            $board->supporting_doc = $supporting_doc_fileName;
        }
         $board->save();
         $id = $board->id;
         $topID = $request->topID;
        if($topID != null){
            $TP = count($topID);
            
            for($i=0; $i < $TP; $i++)
            {
                $var1 = $topID[$i];
                if($var1 != ""){
                $topnotcher = Topnotcher::find($var1);
                 $topnotcher->is_updated = 1;
                 $topnotcher->save();
                }
            }
            $top = $request->top;
            $rank = $request->rank;
            
            if($top != null){
             $N = count($top);
             
             for($i=0; $i < $N; $i++)
             {
                 $var1 = $top[$i];
                 $var2 = $rank[$i];
                 if($var1 != "" || $var2 != ""){
                 $topnotcher = new Topnotcher;
                  $topnotcher->boardexam_id = $id;
                  $topnotcher->name = $var1;
                  $topnotcher->rank = $var2;
                  $topnotcher->is_updated = 0;
                  $topnotcher->save();
                 }
             }
            }
        }
        if($request->checkinput != null){
           
            $top = $request->topname;
            $rank = $request->toprank;
 
             $N = count($top);
             
             for($i=0; $i < $N; $i++)
             {
                 $var1 = $top[$i];
                 $var2 = $rank[$i];
                 if($var1 != "" || $var2 != ""){
                 $topnotcher = new Topnotcher;
                  $topnotcher->boardexam_id = $id;
                  $topnotcher->name = $var1;
                  $topnotcher->rank = $var2;
                  $topnotcher->is_updated = 0;
                  $topnotcher->save();
                 }
             }
        }
            
         return redirect()->route('boardDetail',$id)->with('success','');
     }
     public function boardexam_dtb(){
      
          $board = BoardExam::where('archived',0)
          ->orderBy('id','desc')->get();

         return DataTables::of($board)
             ->addColumn('supporting_doc', function($board) {
                if(empty($board->supporting_doc)){
                    return 'None';
                }else{
                    return '<a class="btn btn-sm" target="_blank" href="'.asset('board/'.$board->supporting_doc).'">View</a>';
                }
            })
             ->addColumn('topnotcher', function($board) {
                $countTopnotcher = Topnotcher::
                where('boardexam_id', $board->id)->where('is_updated',0)->
                count();
                return $countTopnotcher;
            })
            ->addColumn('name', function($board) {
                $c = Topnotcher::
                where('boardexam_id', $board->id)->where('is_updated',0)->
                count();
                if($c > 1){
                    
                $top = Topnotcher::where('boardexam_id', $board->id)->where('is_updated',0)->get();
                foreach($top as $t){
                    $list[] = $t->name;
                }
                }
                elseif($c == 1){
                    $top = Topnotcher::where('boardexam_id', $board->id)->where('is_updated',0)->first();
                    $list = $top->name;
                }
                else
                return '';
                return $list;
            })
            
            ->addColumn('actions', function($board) {
                if (auth()->user()->hasPermission('delete-board')) {
                    return '  <a class="btn btn-secondary btn-sm" title="Edit" href="'.route("boardDetail", $board->id).'"><i class="fa fa-eye"></i>
                          </a>
                          <a class="btn btn-secondary btn-sm" title="history" href="'.route("boardHistory", $board->licensure_exam).'"><i class="fa fa-history" aria-hidden="true"></i>
                          </a>
                          <button class="btn btn-danger btn-sm destroy" title="Remove" awardid="'.$board->id.'"><i class="fa fa-trash"></i>
                          </button>';
                }elseif (auth()->user()->hasPermission('view-board')) {
                    return '
                        <a class="btn btn-secondary btn-sm" title="Edit" href="'.route("boardDetail", $board->id).'"><i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-secondary btn-sm" title="history" href="'.route("boardHistory", $board->licensure_exam).'"><i class="fa fa-history" aria-hidden="true"></i>
                        </a>
                        ';
                }else{
                    return '';
                }
            })
            
            ->rawColumns(['actions','supporting_doc','exam_from','exam_to','name'])
            ->make(true);

    }
    public function boardHistory_dtb($exam){
          $board = BoardExam::where('licensure_exam',$exam)
          ->where('archived',0)
          ->orderBy('exam_year','desc')->get();
          $topnotcher = Topnotcher::all();

         return DataTables::of($board)
             ->addColumn('topnotcher', function($board) {
                $countTopnotcher = Topnotcher::
                where('boardexam_id', $board->id)->
                count();
                return $countTopnotcher;
            })
            ->addColumn('exam_from', function($board) {
                if($board->exam_from){
                     $from = date('M. d, Y', strtotime($board->exam_from));
                    return $from;
                }
            })
            ->addColumn('exam_to', function($board) {
                if($board->exam_to){
                     $to = date('M. d, Y', strtotime($board->exam_to));
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
                   if($sum != 0){
                    $percent = ($board->ftaker_passed/$sum)*100;
                    return round($percent, 2).'%';
                   }else
                   return '0%';
            })
            ->addColumn('overall_percentage', function($board) {
                
                  $sum = $board->total_passed+$board->total_failed+$board->total_cond;
                  if($sum != 0){
                   $percent = ($board->total_passed/$sum)*100;
                    return round($percent, 2).'%';
                  }else
                  return '0%';
               
            })
            ->rawColumns(['exam_from','exam_to','topnotcher','ftaker_total','total_total','overall_percentage'])
            ->make(true);
    }

    public function bHistoryfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)
        ->first();
        $exam = $request->licensure;

        $queryBuilder = DB::table('board_exam')
        ->where('licensure_exam',$exam)
        ->where('archived',0);
            
            $queryBuilder = $queryBuilder->orderBy('exam_year','asc');
            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('boardexam::reports.history-report', compact('queryBuilder','department','exam') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
   //return view('boardexam::reports.history-report', compact('queryBuilder','department','exam') );
    }
    public function boardfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $type = $request->examtype;
        $month = $request->examonth; 
        $year = $request->examyear; 
        $min = $request->min; 
        $max = $request->max; 

        $topnotcherQuery = Topnotcher::where('is_updated',0)->get();
        $queryBuilder = DB::table('board_exam')
        ->where('archived',0);
            
            if($type != "All"){
                $queryBuilder = $queryBuilder->where('licensure_exam', $type);
            }
            if($min != "All" && $max != "All" ){
                $queryBuilder = $queryBuilder->whereBetween('exam_year', [$min,$max]);
            }
            if($month != "All"){
                $queryBuilder = $queryBuilder->where('exam_month', $month);
            }
            if($year != "All"){
                $queryBuilder = $queryBuilder->where('exam_year', $year);
            }
            $licensure_exam = $queryBuilder->pluck('licensure_exam')->unique();
            $queryBuilder = $queryBuilder->orderBy('exam_year','asc');
            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('boardexam::reports.boardList-report', compact('queryBuilder','month', 'year','department','type','topnotcherQuery','licensure_exam','min','max') );
        $pdf->setPaper('legal', 'portrait');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
    //return view('boardexam::reports.boardList-report', compact('queryBuilder','month', 'year','department','type','topnotcherQuery','licensure_exam','min','max') );
    }
    public function deleteBoard(Request $request)
    {
        $topnotchers = Topnotcher::where('boardexam_id',$request->id)->get();
        foreach($topnotchers as $t){
            $top = Topnotcher::find($t->id);
           $top->is_updated = 1;
           $top->save();
        }

         $board = BoardExam::find($request->id);
         $board->archived = 1;
         $board->save();
       
    }
    //topnotchers
     public function topnotchers(){
        return view('boardexam::topnotcher');
    }
     public function topnotcher_dtb(){     
         $topnotcher = Topnotcher::join('board_exam','board_exam.id','boardexam_id')
         ->where('topnotchers.is_updated',0)
         ->orderBy('exam_year','desc')->get();
          
         return DataTables::of($topnotcher)
         ->make(true);
    }
    public function topfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $exam = $request->select1; 
        $rank = $request->select2;
        $month = $request->select3; 
        $year = $request->select4; 
        $min = $request->min;
        $max = $request->max;
        $topsummary = $request->summary;
        $var1="";
        $var = '';
        $totalrow =0;
        
        $queryBuilder = DB::table('board_exam')->leftJoin('topnotchers','topnotchers.boardexam_id','board_exam.id')
        ->where('archived',0)
        ->where('is_updated',0);
        
        if($min != "All" && $max !="All"){
            $totalrow = ($max-$min)+2;
            $queryBuilder = $queryBuilder->whereBetween('exam_year', [$min,$max]);
        }
        // if($topsummary == "SBT"){
        //     $queryBuilder = $queryBuilder->whereNotNull('school_rank');
        // }
            if($month){
                $queryBuilder = $queryBuilder->where('exam_month', $month);
            }
            if($year){
                $queryBuilder = $queryBuilder->where('exam_year', $year);
            }
            if($exam){
                $queryBuilder = $queryBuilder->where('licensure_exam', $exam);
            }
            if($rank){
                $queryBuilder = $queryBuilder->where('rank', $rank);
            }
            
            if($topsummary != ""){
            $var = $topsummary;
        }
            $licensure_exam = $queryBuilder->pluck('licensure_exam')->unique();
            $queryBuilder = $queryBuilder->orderBy('exam_year','asc');
            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('boardexam::reports.topnotcher-report', compact('queryBuilder','month', 'year','department','exam','rank','licensure_exam','min','max','var') );
      if($totalrow < 7)
        $pdf->setPaper('legal', 'portrait');
    else
    $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
    // return view('boardexam::reports.topnotcher-report', compact('queryBuilder','month', 'year','department','exam','rank','licensure_exam','min','max') );
    }
}
