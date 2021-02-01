<?php

namespace Modules\AlumniDatabase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Alumni;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Illuminate\Support\Facades\{Hash};
use Yajra\Datatables\Datatables;
use DB;
use Mail;
class AlumniGraduateController extends Controller
{
    public function index()
    {
        return view('alumnidatabase::graduate.index');
    }
    public function addGraduate(Request $request)
    {
        
        $fname = substr($request->firstname, 0, 1);
        $email = $request->lastname.'_'.$fname;
    $password = Hash::make( $request->idnumber);
        $graduate = new Alumni;
        $graduate->id_number = $request->idnumber;
        $graduate->first_name = $request->firstname;
        $graduate->middle_name = $request->middlename;
        $graduate->last_name = $request->lastname;
        $graduate->email = $email;
        $graduate->user_role = "graduate";
        $graduate->school_id = $request->school;
        $graduate->program_id = $request->program;
        $graduate->semester = '1st Semester';
        $graduate->school_year = '2020 - 2021';
        $graduate->major = $request->major;
        $graduate->password = $password;
        $graduate->remarks = "For Evaluation";
        $graduate->save();
        //$email = $request->email;
        //$data = array('name'=>"University of Baguio");
     
        // Mail::send(['html'=>'mail'], $data, function($message) use ($email){
        //    $message->to($email, 'Feedback Form')->subject
        //       ('Graduating Students Information and Feedback Form');
        //    $message->from('lheamor28@gmail.com','University of Baguio');
        // });
        if (! $graduate->save()) {
            return back()->with('error', '');
        } else {
            return back()->with('success', '');
        }
    } 
    public function addAccount(Request $request){    

    $pass = explode('@',$request->email);
    $password = Hash::make($pass[0]);
        $graduate = new Alumni;
        $graduate->email = $request->email;
        $graduate->user_role = "secretary";
        $graduate->school_id = $request->school;
        $graduate->program_id = 2;
        $graduate->remarks = "For Log In";
        $graduate->password = $password;
        $graduate->save();
        $email = $request->email;
       // $data = array('name'=>"University of Baguio");
     
        // Mail::send(['html'=>'mail'], $data, function($message) use ($email){
        //    $message->to($email, 'Feedback Form')->subject
        //       ('Graduating Students Information and Feedback Form');
        //    $message->from('lheamor28@gmail.com','University of Baguio');
        // });
        if (! $graduate->save()) {
            return back()->with('error', '');
        } else {
            return back()->with('successAcount', '');
        }
    }
    public function graduatefilterReport(Request $request)
    {
        $department = School::where('id', auth()->guard('alumni')->user()->school_id)->first();
        $school = $request->select1; 
        $program = $request->select2; 
        $sem = $request->select3; 
        $schoolyear = $request->select4;

        $schoolID = School::where('school_code',$school)->first();
        $progID = AcadPrgrm::where('acad_prog_code',$program)->first();

        $queryBuilder = DB::connection('mysql2')->table('users')->join('qasystem.schools','qasystem.schools.id','alumni.users.school_id')
        ->join('qasystem.acad_prgrms','qasystem.acad_prgrms.id','alumni.users.program_id')
        ->where('alumni.users.user_role','graduate');
        if(auth()->guard('alumni')->user()->user_role != 'admin'){
            $queryBuilder = $queryBuilder->where('alumni.users.school_id', auth()->guard('alumni')->user()->school_id);
        }
            
            if($school){
                $queryBuilder = $queryBuilder->where('alumni.users.school_id', $schoolID->id);
            }
            if($program){
                $queryBuilder = $queryBuilder->where('alumni.users.program_id', $progID->id);
            }

            if($sem){
                $queryBuilder =$queryBuilder->where('alumni.users.semester', $sem);
            }

            if($schoolyear){
                $queryBuilder =$queryBuilder->where('alumni.users.school_year', $schoolyear);
            }

            $queryBuilder = $queryBuilder->get();

        //      $pdf = PDF::loadView('quantitativereport::reports.employee-report', compact('queryBuilder','department', 'sem', 'schoolyear'));
        // $pdf->setPaper('legal', 'landscape');
        // $pdf->save(storage_path().'_filename.pdf');

        // return $pdf->stream('project_'.time().'.pdf');
        return view('alumnidatabase::reports.graduate-report', compact('queryBuilder','program','school', 'sem', 'schoolyear','department'));
    }
    public function graduate_select(Request $request){
        $programs = AcadPrgrm::where('school_id', $request->id)->get();
        echo '<select class="form-control-sm form-control" id="program" name="program" required>';

        if ($programs->count() != 0){
            foreach ($programs as $program) {
                echo "<option value='".$program->id."'>".$program->acad_prog."</option>";
            } 
        }else{
            echo "<option disabled selected value >No Academic Program Added yet</option>";
        }
        
        echo "</select>";
    }
    public function graduate_dtb(Request $request){
        $graduate = DB::table('alumni.users')->join('qasystem.schools', 'qasystem.schools.id', 'alumni.users.school_id')
            ->join('qasystem.acad_prgrms', 'qasystem.acad_prgrms.id', 'alumni.users.program_id')
            ->where('alumni.users.user_role', 'graduate')
            ->where('alumni.users.semester', '2nd Sem')
            ->where('alumni.users.school_year', '2020 - 2021');
        if (auth()->guard('alumni')->user()->user_role != 'admin')
            $graduate = $graduate->where('alumni.users.school_id', auth()->guard('alumni')->user()->school_id);
          
            $graduate = $graduate->select('*', 'alumni.users.id as e_id')->get();
    

        //     <a class="btn btn-primary btn-sm" title="resend" href="'.route("sendbasicemail", $graduate->email).'">
        //     <i class="fa fa-share-square" aria-hidden="true"></i>
        // </a>
     return DataTables::of($graduate)
        
        ->addColumn('actions', function($graduate) {
                return '
                    <a class="btn btn-info btn-sm" title="edit" href="'.route("alumniGraduateEdit", $graduate->e_id).'">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </a>
                    
                    <button class="btn btn-danger btn-sm destroy" title="Remove" enid="'.$graduate->e_id.'"><i class="fa fa-trash"></i>
                    </button>
                    ';
                
        })
        ->rawColumns(['actions'])
        ->make(true);
}
public function useraccount_dtb(Request $request){
    $user = DB::table('alumni.users')->join('qasystem.schools','qasystem.schools.id','alumni.users.school_id')
    ->where('alumni.users.user_role','secretary')
    ->select('*','alumni.users.id as e_id')
    ->get();

return DataTables::of($user)

->addColumn('actions', function($user) {
        return '
            <button class="btn btn-secondary btn-sm edit" accountid="'.$user->e_id.'"><i class="fa fa-edit"></i>
            
            <button class="btn btn-danger btn-sm destroy" title="Remove" enid="'.$user->e_id.'"><i class="fa fa-trash"></i>
            </button>
            ';
})
->rawColumns(['actions'])
->make(true);
}
    public function deleteGraduate(Request $request){
        $graduate = Alumni::find($request->id);
        $graduate->delete();

    }
    public function graduateEdit($id){
        $list = School::where('school_name','like','%School%')->get();
        
        $acad_prog = AcadPrgrm::join('schools', 'schools.id', 'acad_prgrms.school_id')
        ->select('*','acad_prgrms.id as a_id')
        ->get();
        $sch = School::all();
        $userRole = auth()->guard('alumni')->user()->user_role;
        $graduate = DB::connection('mysql2')->table('users')->where('id', $id)->first();

        return view('alumnidatabase::secretary.graduate-edit', compact('graduate','list','acad_prog','sch','userRole'));
    }
    public function accountEdit(Request $request){
        $user = Alumni::find($request->id);
        $school = School::find($user->school_id);
        echo ' <div class="col-md-12">
        <label><span class="text-danger">*</span>School:</label>
         <input class="form-control" disabled value="'.$school->school_name.'">
            </div>
            <div class="col-md-12 form-group">
                <label><span class="text-danger">*</span>Email</label>
                <input type="email" name="email" class="form-control" required value="'.$user->email.'">
                
            <label><span class="text-danger">Default password is their school code ex. qao</span></label>
            </div>

            <input type="hidden" name="sid" value="'.$request->id.'"></input>';
    }
    public function updateAccount(Request $request)
    {
        $user = Alumni::find($request->sid);
        $user->email = $request->email;
        $user->save();

            if (! $user->save()) {
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
    public function updateGraduate(Request $request){
        $password = Hash::make( $request->idnumber);

        $graduate = Alumni::find($request->id);
        $graduate->id_number = $request->idnumber;
        $graduate->first_name = $request->firstname;
        $graduate->middle_name = $request->middlename;
        $graduate->last_name = $request->lastname;
        $graduate->email = $request->email;
        $graduate->user_role = "graduate";
        $graduate->program_id = $request->program;
        $graduate->semester = '2nd Sem';
        $graduate->school_year = '2020 - 2021';
        $graduate->major = $request->major;
        $graduate->password = $password;
        $graduate->save();
        
        if (! $graduate->save()) {
            return redirect()->route('graduateindex')->with('error', '');
        } else {
            return redirect()->route('graduateindex')->with('update', '');
        }
    }
}