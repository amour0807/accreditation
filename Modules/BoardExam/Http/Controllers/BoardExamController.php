<?php

namespace Modules\BoardExam\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BoardExam\Entities\BoardExam;
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
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('boardexam::index');
    }
    public function boardDetail($id)
    {
        $board = BoardExam::where('id',$id)->first();
        $topnotcher = Topnotcher::where('boardexam_id',$id)->get();

        return view('boardexam::boardDetail',compact('board','topnotcher'));
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
           $top = $request->top;
           $rank = $request->rank;

            $N = count($top);
            for($i=0; $i < $N; $i++)
            {
                $topnotcher = new Topnotcher;
                 $var1 = $top[$i];
                 $var2 = $rank[$i];
                 $topnotcher->boardexam_id = $id;
                 $topnotcher->name = $var1;
                 $topnotcher->rank = $var2;
                 $topnotcher->save();
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
                        ';
            })
            
            ->rawColumns(['actions','supporting_doc','exam_date'])
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
}
