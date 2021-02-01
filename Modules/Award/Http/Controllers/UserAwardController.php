<?php

namespace Modules\Award\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Modules\Award\Entities\Award;
use Yajra\Datatables\Datatables;
use App\User;
use DB;
use Validator;

use PDF;
use Session;


class UserAwardController extends Controller
{

    public function index()
    {
        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id');
        if(!auth()->user()->hasRole('admin')){
            $acad_prog = $acad_prog->where('school_id', auth()->user()->school_id);
        }
        $acad_prog = $acad_prog->select('*','acad_prgrms.id as a_id');
        $acad_prog = $acad_prog->get();

        $award = Award::all();
        $school = School::where('id', auth()->user()->school_id)->first();
        $user_role = DB::table('users_roles')->where('user_id',auth()->user()->id)->first();
        $user = User::where('id',auth()->user()->id)->first();
        return view('award::others.index', compact('school','award','acad_prog','user_role','user'));
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_initial} {$this->last_name}";
    }
    
     public function userAward_dtb(Request $request){
         $id = auth()->user()->school_id;

            $awards = Award::join('acad_prgrms', 'acad_prgrms.id', 'awards.acad_prgram_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->select('*','awards.id as a_id');
            
         if(!auth()->user()->hasRole('admin')){
            $awards->where('acad_prgrms.school_id', $id);
         }
       
        $awards->select('*', 'awards.id as a_id');
        $awards->get(); 
        
         return DataTables::of($awards)
             ->addColumn('date_awarded', function($awards) {
                if($awards->date_awarded){
                     $datea = date('M. d, Y', strtotime($awards->date_awarded));
                    return $datea;
                }
            })
            ->addColumn('actions', function($awards) {
                if(empty($awards->award_cert)){
                    $award_cert = "NO CERTIFICATE";
                }else{
                    $award_cert = "WITH CERTIFICATE";
                }
                if(auth()->user()->hasRole('admin')){
                    return '
                        <a class="btn btn-info btn-sm" href="'.route("userAwardDetails", $awards->a_id).'">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        ';
                }else{
                    return '
                        <a class="btn btn-info btn-sm" href="'.route("userAwardDetails", $awards->a_id).'">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" awardid="'.$awards->a_id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
                }
                    
            })
            ->addColumn('awardcert', function($awards) {
                
            })
            ->rawColumns(['actions','awardcert','date_awarded'])
            ->make(true);

            return view('award::others.index', compact('awards'));
    }
       public function deleteCert(Request $request){
        $awards = Award::where('id', $request->fileId)->first();

            $awards->award_cert='';
        $awards->save();
        Session::flash('red', 'Record Deleted!'); 
      
    }

    public function userAwardDetails($id){
        $award = DB::table('awards')->join('acad_prgrms','acad_prgrms.id', 'awards.acad_prgram_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('awards.id', $id)
            ->select('*','awards.id as aw_id')
            ->get();

        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id')
        ->where('school_id', auth()->user()->school_id)
        ->select('*','acad_prgrms.id as a_id')
        ->get();

        return view('award::others.award-details', compact('award','acad_prog'));

    }

     public function userAwardEdit($id){
       $award = DB::table('awards')->join('acad_prgrms','acad_prgrms.id', 'awards.acad_prgram_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id')
            ->where('awards.id', $id)
            ->select('*','awards.id as aw_id')
            ->first();
        
        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id');
        if(!auth()->user()->hasRole('admin')){
            $acad_prog = $acad_prog->where('school_id', auth()->user()->school_id);
        }
        $acad_prog = $acad_prog->select('*','acad_prgrms.id as a_id');
        $acad_prog = $acad_prog->get();

        $school = School::where('id', auth()->user()->school_id)->first();

        return view('award::others.award-edit', compact('award','acad_prog','school'));
    }

    public function addStudentAward(Request $request){
       $request->validate([
            'award_cert' => 'nullable|mimes:jpeg,png,pdf|max:10240',
            ]);

       $data = Validator::make($request->all(),[
            'last_name' => "required",
            'first_name' => "required",
            'acad_prgram_id' => "required",
            'scope' => "required",
            'category' => "required",
            'classification' => "required",
            'award' => "required", 
            'title_competitions' => "required",
            'award_giving_body' => "required",
            'date_awarded' => "required"      
        ]);

       if($request->award == "others"){
        $awards = $request->others;
       }else{
        $awards = $request->award;
       }

       if($request->award == "others2"){
        $awards = $request->others2;
       }else{
        $awards = $request->award;
       }
       
        $award_cert_fileName ="blank_cert.png";
       if($request->hasFile('award_cert')){
            
            $award_cert_fileName = 'award_cert_'.time().'.'.request()->award_cert->getClientOriginalExtension();  
       
            request()->award_cert->move(public_path('certificates'), $award_cert_fileName);
        }

        if($request->middle_i == "")
            $middle_i = "";
        else
            $middle_i = $request->middle_i;
        

        $award = new Award;
        $award->last_name = $request->last_name ;
        $award->first_name = $request->first_name ;
        $award->middle_initial = $middle_i ;
         $award->acad_prgram_id = $request->acad_prgram_id;
         $award->scope = $request->scope;
         $award->category = $request->category;
        $award->classification = $request->classification;
         $award->award = $awards;
         $award->title_competitions = $request->title_competitions;
         $award->award_giving_body = $request->award_giving_body;
         $award->date_awarded = $request->date;
         $award->venue = $request->venue;
         $award->award_cert = $award_cert_fileName;


        $award->save();
        return back()->with('success', '');
    }

    public function updateStudentAward(Request $request)
    {
         if($request->award2 == "others")
        $awards = $request->others1;
       else
        $awards = $request->award2;
           
        $award = Award::find($request->awardID);
        $award->last_name = $request->last_name2;
        $award->middle_initial = $request->middle_i2;
        $award->first_name = $request->first_name2;
         $award->acad_prgram_id = $request->acad_prgram_id2;
         $award->scope = $request->scope2;
         $award->category = $request->category2;
        $award->classification = $request->classification2;
         $award->award = $awards;
         $award->title_competitions = $request->title_competitions2;
         $award->award_giving_body = $request->award_giving_body2;
         $award->date_awarded = $request->date2;
         $award->venue = $request->venue2;

         if($request->hasFile('award_cert_file')){
            
            $award_cert_fileName = 'award_cert_file'.time().'.'.request()->award_cert_file->getClientOriginalExtension();  
       
            request()->award_cert_file->move(public_path('certificates'), $award_cert_fileName);
            $award->award_cert = $award_cert_fileName;
        }else{
            $award->award_cert = $request->award_cert;
        }
        
        $award->save();

        return redirect()->route('userAwardDetails', $request->awardID)->with('success','');
    }
    
     public function deleteAward(Request $request)
    {
        $award = Award::find($request->id);
        $award->delete();
       
    }

    public function userawardfilterReport(Request $request)
    {
        $department = School::where('id', auth()->user()->school_id)->first();
        $from = $request->min; 
        $to = $request->max; 
        $scope = $request->select1;
        $category = $request->select2;

        $queryBuilder = DB::table('awards')
            ->join('acad_prgrms', 'acad_prgrms.id', 'awards.acad_prgram_id')
            ->join('schools', 'schools.id', 'acad_prgrms.school_id');
            
        
            if(!auth()->user()->hasRole('admin')){
                $queryBuilder->where('schools.id', auth()->user()->school_id);
            }
            if($from != 'All' && $to != 'All'){
                $queryBuilder = $queryBuilder->where(function ($queryBuilder) use($from, $to){
                    $queryBuilder->whereYear('date_awarded', '>=', $from)
                        ->whereYear('date_awarded', '<=', $to);
                });
            }

            if($scope){
                $queryBuilder =$queryBuilder->where('awards.scope', $scope);
            }

            if($category){
                $queryBuilder =$queryBuilder->where('awards.category', $category);
            }
            
            $queryBuilder = $queryBuilder->orderBy('date_awarded','desc');
            $queryBuilder = $queryBuilder->get();

             $pdf = PDF::loadView('award::reports.useraward-report', compact('queryBuilder','scope', 'from', 'to', 'category', 'department'));
        $pdf->setPaper('legal', 'landscape');
        $pdf->save(storage_path().'_filename.pdf');

        return $pdf->stream('project_'.time().'.pdf');
        // return view('award::reports.useraward-report', compact('queryBuilder','scope', 'from', 'to', 'category', 'department'));
    }

}
