<?php

namespace Modules\AlumniDatabase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Accreditation\Entities\AcadPrgrm;
use Illuminate\Support\Facades\{Hash,Auth,Input};
use Modules\Accreditation\Entities\School;
use Yajra\Datatables\Datatables;
use DB;

class AlumniController extends Controller
{
    public function index()
    {
        return view('alumnidatabase::secretary.index');
    } 
    public function userAccount()
    {  
        $list = School::where('school_name','like','%School%')->orderBy('school_name','asc')->get();
        return view('alumnidatabase::admin.index', compact('list'));
        
    }
    public function firstloginAlumni()
    {
        return view('alumnidatabase::secretary.firstlogin');
    }
    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::guard('alumni')->user()->password))) {
   
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::guard('alumni')->user();
        $user->password = bcrypt($request->get('new-password'));
        $user->remarks = "Active";
        $user->save();

        return redirect()->route('secretary')->with("successPassword","");
    }
    public function graduateindex(){
        $schoolid = auth()->guard('alumni')->user()->school_id;
        $list = School::where('id',$schoolid)->get();
        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id')
        ->where('acad_prgrms.school_id',$schoolid)
        ->select('*','acad_prgrms.id as a_id')
        ->get();
        $sch = School::all();
        return view('alumnidatabase::secretary.graduate',compact('sch','list','acad_prog'));
    }
    public function viewSchool(){
        return view('alumnidatabase::secretary.school-index');

    }
    public function school_dept_dtb(){
        $school = School::all();   
       // $filter = Category::where('name', 'like', 'A%')->orderBy('name', 'asc')->get();
         return DataTables::of($school)
            ->addColumn('actions', function($school) {
                
                    return '
                        <button class="btn btn-secondary btn-sm edit" title="Edit" schoolid="'.$school->id.'"><i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" schoolid="'.$school->id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function addSchoolForm(Request $request){
        $scheck = School::all();
        foreach($scheck as $sc){
            if($sc->school_code == $request->school_code){
                $success = false;
                $message = "Duplicate entry!";
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
            $school = new School;
            $school->school_name = $request->school_name;
            $school->school_code = $request->school_code;
            $school->save();
            
            if (! $school->save()) {
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
    public function deleteSchoolDept(Request $request){
        $school = School::find($request->id);
        $school->delete();
    }
    public function editSchoolDept(Request $request){
        $school = School::find($request->id);
        echo '<label>School Code</label> <input type="text" class="form-control" name="school_code" required value="'.$school->school_code.'"></input>
            <label>School Name</label> <input type="text" class="form-control" name="school_name" required value="'.$school->school_name.'"></input>

            <input type="hidden" name="sid" value="'.$request->id.'"></input>';      
    }
    public function updateSchoolDept(Request $request){
        $school = School::find($request->sid);
        $school->school_code = $request->school_code;
        $school->school_name = $request->school_name;
        $school->save();
        
            if (! $school->save()) {
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
}
