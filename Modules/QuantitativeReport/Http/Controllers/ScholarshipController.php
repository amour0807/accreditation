<?php

namespace Modules\QuantitativeReport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Modules\QuantitativeReport\Entities\ScholarDiscount;
use Yajra\Datatables\Datatables;
use App\User;

use Modules\QuantitativeReport\Entities\Scholarship;
use DB;
use Validator;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use PDF;
use PdfReport;
use \Carbon\Carbon;

class ScholarshipController extends Controller
{
    public function index(){
        $list = Scholarship::all();
        
        return view('quantitativereport::scholarship.scholarIndex', compact('list'));
    }
    public function listScholar(){
        $list = Scholarship::all();
        
        return view('quantitativereport::scholarship.list-scholar', compact('list'));
    }
    public function scholarDetail($id){
        $scholar = Scholarship::join('scholar_discounts','scholar_discounts.scholarship_id','scholars.id')
        ->where('scholar_discounts.id',$id)
        ->select('*','scholar_discounts.id as s_id')
        ->first();
        return view('quantitativereport::scholarship.scholar-detail',compact('scholar'));
    }
    public function scholar_dtb(Request $request){
           $scholarship = Scholarship::join('scholar_discounts','scholar_discounts.scholarship_id','scholars.id')
           ->orderBy('scholar_discounts.school_year','desc')
           ->select('*','scholar_discounts.id as s_id')
           ->get();
       
        return DataTables::of($scholarship)
            ->addColumn('totalno', function($scholarship) {
                       $totalno = ($scholarship->fno)+($scholarship->sno)+($scholarship->stno);
                    return number_format($totalno);    
           })
           ->addColumn('totalphp', function($scholarship) {
                        $totalphp = ($scholarship->fphp)+($scholarship->sphp)+($scholarship->stphp);
                    return number_format($totalphp);    
            })
           ->addColumn('actions', function($scholarship) {
            if(auth()->user()->hasPermission('edit-scholar') && auth()->user()->hasPermission('delete-scholar')){
                   return '
                       <a class="btn btn-info btn-sm" href="'.route("scholarDetail", $scholarship->s_id).'">
                           <i class="fa fa-eye" aria-hidden="true"></i>
                       </a>
                       
                       <button class="btn btn-danger btn-sm destroy" title="Remove" empid="'.$scholarship->s_id.'"><i class="fa fa-trash"></i>
                       </button>
                       ';
            }else{
                return '
                       <a class="btn btn-info btn-sm" href="'.route("scholarEdit", $scholarship->id).'">
                           <i class="fa fa-edit" aria-hidden="true"></i>
                       </a>
                       ';
            }
               
                   
           })
           ->rawColumns(['actions','totalno','totalphp'])
           ->make(true);
   }
   public function addScholar(Request $request){
    $check = ScholarDiscount::all();
    $success="";
  foreach($check as $ac){
      if($ac->scholarship_id == $request->scholarshipID && $ac->school_year == $request->school_year){
          $success = false;
          $message = "Duplicate entry!";
          return response()->json([
              'success' => $success,
              'message' => $message,
          ]);
      }
  }
    $scholar = new ScholarDiscount;
    $scholar->scholarship_id = $request->scholarshipID ;
    $scholar->school_year = $request->school_year ;
    $scholar->fno = $request->fno ;
    $scholar->fphp = $request->fphp ;
     $scholar->sno = $request->sno;
     $scholar->sphp = $request->sphp;
     $scholar->stno = $request->stno;
     $scholar->stphp = $request->stphp;

    $scholar->save();
    if (! $scholar->save()) {
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

   public function updateScholar(Request $request){

    $scholar = ScholarDiscount::find($request->discountid);
    $scholar->scholarship_id = $request->scholarshipID ;
    $scholar->school_year = $request->school_year ;
    $scholar->fno = $request->fno ;
    $scholar->fphp = $request->fphp ;
     $scholar->sno = $request->sno;
     $scholar->sphp = $request->sphp;
     $scholar->stno = $request->stno;
     $scholar->stphp = $request->stphp;

    $scholar->save();
    return redirect()->route('scholarIndex')->with('update', '');
   }

   public function scholarEdit($id){
       
    $list = Scholarship::all();
    $scholar = Scholarship::join('scholar_discounts','scholar_discounts.scholarship_id','scholars.id')
    ->where('scholar_discounts.id',$id)
    ->select('*','scholar_discounts.id as s_id')
    ->first();
    return view('quantitativereport::scholarship.scholar-edit',compact('scholar','list'));
 }
 public function deleteScholar(Request $request){
     $scholar = ScholarDiscount::find($request->id);
     $scholar->delete();
    
 }
 public function scholarfilterReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $scholarship = $request->select1; 
        $schoolyear = $request->select2;
        $from = $request->from; 
        $to = $request->to;

        $id = Scholarship::where('scholar_title', $scholarship)->first();

        $queryBuilder = ScholarDiscount::join('scholars','scholars.id','scholar_discounts.scholarship_id');
            
            if($scholarship){
                $queryBuilder = $queryBuilder->where('scholars.id', $id->id);
            }

            if($schoolyear){
                $queryBuilder =$queryBuilder->where('scholar_discounts.school_year', $schoolyear);
            }
            if($from != 'All' && $to != 'All'){
                $syfrom = ($from-1).' - '.$from;
                $syto = ($to-1).' - '.$to;
                $queryBuilder = $queryBuilder->where(function ($queryBuilder) use($syfrom, $syto){
                    $queryBuilder->where('school_year', '>=', $syfrom)
                        ->where('school_year', '<=', $syto);
                });
            }

          
            $queryBuilder = $queryBuilder->get();

             $pdf = PDF::loadView('quantitativereport::reports.scholar-report', compact('queryBuilder','scholarship', 'schoolyear','department','from','to'));
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
       // return view('quantitativereport::reports.scholar-report', compact('queryBuilder','scholarship', 'schoolyear','department'));
    }

   //LIST
   public function list_dtb(Request $request){
    $scholarship = Scholarship::all();

 return DataTables::of($scholarship)
    ->addColumn('actions', function($scholarship) {
     if(auth()->user()->hasPermission('edit-scholar') && auth()->user()->hasPermission('delete-scholar')){
            return '
            <button class="btn btn-secondary btn-sm edit" statusid="'.$scholarship->id.'"><i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-danger btn-sm destroy" statusid="'.$scholarship->id.'"><i class="fa fa-trash"></i>
            </button>';
     }  
    })
    ->rawColumns(['actions'])
    ->make(true);
}
    public function addList(Request $request){
        $all = Scholarship::all();
        $success="";
      foreach($all as $ac){
          if($ac->scholar_title == $request->scholartitle){
              $success = false;
              $message = "Duplicate entry!";
              return response()->json([
                  'success' => $success,
                  'message' => $message,
              ]);
          }
      }
      $scholarship = new Scholarship;
      $scholarship->scholar_title = $request->scholartitle;
      $scholarship->category = $request->category;
      $scholarship->type = $request->type;
      $scholarship->company = $request->company;
      $scholarship->save();

          
          if (! $scholarship->save()) {
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
    public function editList(Request $request)
    {
        $scholarship = Scholarship::find($request->id);
        echo '<input type="hidden" name="sid" value="'.$scholarship->id.'"></input>	<label><span class="text-danger">* Required Fields</span></label>
        <div class="form-group">
        <label><span class="text-danger">*</span>Scholarship Title</label>
        <input type="text" name="scholartitle" value="'.$scholarship->scholar_title.'" required class="form-control">
        </div>
        
        <div class="row form-group">
              
        <div class="col-md-6 col-sm-6">
          <label><span class="text-danger">*</span>Type</label>
        <select class="form-control small" name="type" required>
            <option value = "Grant" '.$scholarship->type.' == "Grant" ? selected="selected":""> Grant </option>
            <option value = "Scholarship" '.$scholarship->type.' == "Scholarship" ? selected="selected":""> Scholarship  </option>
                  </select>
        </div>
        <div class="col-md-6 col-sm-6">
        <label><span class="text-danger">*</span>Category</label>
        <select class="form-control small" name="category" onchange="CheckAward(this.value);" required>
                      <option value = "Internal" '.$scholarship->category.' == "Internal" ? selected="selected":""> Internal </option>
                     
                      <option value = "External" '.$scholarship->category.' == "External" ? selected="selected":""> External  </option>
                  </select>
                ';
                if($scholarship->category == 'External'){
                    echo'
                <div id="others2" style="display:block;">
                    <span class="text-danger">*</span><input type="text" class="form-control" name="company" value="'.$scholarship->company.'">
                </div>';
                }
                
      echo'
  </div>      
        </div>
      </div>';

        
    }

    public function updateList(Request $request){
        $scholarship = Scholarship::find($request->sid);
        $scholarship->scholar_title = $request->scholartitle;
        $scholarship->category = $request->category;
        $scholarship->company = $request->company;
        $scholarship->save();

            if (! $scholarship->save()) {
                throw new Exception('Error in saving data.');
            } else {
                $success = true;
                $message = "Successfuly Updated!";
            }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
    public function deleteList(Request $request)
    {
        $scholar = Scholarship::find($request->id);
        $scholar->delete();

        
    }
}
