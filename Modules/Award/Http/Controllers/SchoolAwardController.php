<?php

namespace Modules\Award\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Award\Entities\SchoolAward;
use Modules\Accreditation\Entities\School;
use Yajra\Datatables\Datatables;
use DB;
use PDF;
use Session;


class SchoolAwardController extends Controller
{
    public function schoolAward(){
        $award = SchoolAward::all()->unique('award')->sortBy('award');
        $school = School::where('school_name', 'like','%School%')->orderBy('school_name','asc')->get();
        
        return view('award::schoolAward',compact('school','award'));
    }


    public function schoolAwardEdit($id){

        $schoolAward = SchoolAward::where('id', $id)->first();
        $school = School::where('school_name', 'like','%School%')->get();
        return view('award::schoolAward-edit', compact('schoolAward','school'));
    }

    public function schoolAward_dtb($id){
        $schoolAward = DB::table('school_awards')->orderBy('from','desc')->get();

         return DataTables::of($schoolAward)
         ->addColumn('school_name', function($schoolAward) {
             $name = School::where('id',$schoolAward->school_id)->first();
            $school_name = $name->school_code;
            return $school_name;
        })
         ->addColumn('dfrom', function($schoolAward) {
            $dateValue_from = $schoolAward->from;
            $dateValue = $schoolAward->to;
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
         ->addColumn('from', function($schoolAward) {
            if(($schoolAward->from) != "")
                $from = date('M. d, Y', strtotime($schoolAward->from));
            else
                $from = "";
            return $from;
        })
         ->addColumn('to', function($schoolAward) {
            if(($schoolAward->from) != "")
                $to = date('M. d, Y', strtotime($schoolAward->to));
            else
                $to = "";
            return $to;
        })
        ->addColumn('dsupporting_doc', function($schoolAward) {
            if(empty($schoolAward->supporting_doc)){
                return 'None';
            }else{
                return '<a target="_blank" href="'.asset('certificates/'.$schoolAward->supporting_doc).'">View</a>';
            }
        })
        ->addColumn('actions', function($schoolAward) {
            if (auth()->user()->hasPermission('edit-schoolAward','delete-schoolAward')) {
                return '
                    <a class="btn btn-info btn-sm" href="'.route("schoolAwardEdit", $schoolAward->id).'"> <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" awardID="'.$schoolAward->id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
            }
            })
        
            
            ->rawColumns(['actions','dfrom','dsupporting_doc'])
            ->make(true);
    }

    public function deleteSchoolAward(Request $request){
        $school = SchoolAward::find($request->id);
        $school->delete();
    }

    public function updateSchoolAward(Request $request){
       
        $schoolAward = SchoolAward::find($request->awardID);
        $schoolAward->school_id = $request->school_id;
        $schoolAward->award = $request->award;
        $schoolAward->scope = $request->scope;
        $schoolAward->from = $request->from;
        $schoolAward->to = $request->to;
        $schoolAward->venue = $request->venue;
        $schoolAward->award_giving_body = $request->award_gb;
        

         if($request->hasFile('award_cert_file')){
            
            $award_cert_fileName = 'award_cert_file'.time().'.'.request()->award_cert_file->getClientOriginalExtension();  
       
            request()->award_cert_file->move(public_path('certificates'), $award_cert_fileName);
            $schoolAward->supporting_doc = $award_cert_fileName;
        }else{
            $schoolAward->supporting_doc = $schoolAward->supporting_doc;
        }
        
        $schoolAward->save();

        return redirect()->route('schoolAward')->with('success', '');
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

    public function schoolAwardfilterReport(Request $request){
        $department = School::where('id', auth()->user()->school_id)->first();
        $instAward = DB::table('school_awards')->get();
        $from = $request->min; 
        $to = $request->max; 
        $school = $request->school1;
        $award = $request->award1;
        $scope = $request->scope1;
        $id = School::where('school_code',$school)->first();
        $queryBuilder = DB::table('school_awards')->join('schools', 'schools.id', 'school_awards.school_id');
            if($from != 'All' && $to != 'All'){
                $queryBuilder = $queryBuilder->where(function ($queryBuilder) use($from, $to){
                    $queryBuilder->whereYear('from', '>=', $from)
                        ->whereYear('to', '<=', $to);
                });
            }
            if($school != 'All'){
                $queryBuilder =$queryBuilder->where('school_awards.school_id',$id->id);
            }
            if($award != 'All'){
                $queryBuilder =$queryBuilder->where('school_awards.award', $award);
            }
            if($scope != 'All'){
                $queryBuilder =$queryBuilder->where('school_awards.scope', $scope);
            }

            $queryBuilder = $queryBuilder->get();

      $pdf = PDF::loadView('award::reports.schoolAwards-report', compact('queryBuilder', 'instAward', 'award', 'department', 'from', 'to','scope','school') );
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
     //return view('award::reports.schoolAwards-report', compact('queryBuilder', 'instAward', 'award', 'department', 'from', 'to','scope','school') );
    }

    public function addSchoolAward(Request $request){
        $request->validate([
             'supporting_doc' => 'nullable|mimes:jpeg,png,pdf|max:10240',
             ]);
             
             $check = SchoolAward::all();
             $success="";
           foreach($check as $ac){
               if($ac->award == $request->award && $ac->school_id == $request->school_id && $ac->from == $request->from){
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

         $schoolAward = new SchoolAward;
         $schoolAward->school_id = $request->school_id;
         $schoolAward->award = $request->award;
         $schoolAward->scope = $request->scope;
         $schoolAward->from = $request->from;
         $schoolAward->to = $request->to;
         $schoolAward->venue = $request->venue;
         $schoolAward->award_giving_body = $request->award_gb;
         $schoolAward->supporting_doc = $supporting_doc_fileName;
 
         $schoolAward->save();

         if (! $schoolAward->save()) {
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
