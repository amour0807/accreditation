<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\{Hash,Auth,Input};
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use DB;
use Modules\User\Entities\User;
use Modules\Accreditation\Entities\School;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $school = School::all();
        return view('user::index', compact('school'));
    }

    public function account_dtb($id){
         $users = User::join('schools', 'schools.id', 'users.school_id')
          ->select('*','users.id as u_id')
          ->get();

        
         return DataTables::of($users)
            ->addColumn('actions', function($users) {
                    return '
                        <button class="btn btn-secondary btn-sm edit" title="View" 
                            userid="'.$users->u_id.'"
                            user_role="'.$users->user_role.'"
                            status="'.$users->status.'"
                            lastname="'.$users->last_name.'"
                            middlei="'.$users->middle_initial.'"
                            firstname="'.$users->first_name.'"

                        ><i class="far fa-eye"></i>
                        </button>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" userid="'.$users->u_id.'"><i class="far fa-trash-alt"></i>
                        </button>
                        ';
            
            })
            
            ->rawColumns(['actions'])
            ->make(true);
            return view('user::index', compact('users'));
    }

     public function addUser(Request $request){
        $school = School::find($request->school_id);

        // $password = md5( $request->id_num .$salt);
        if($request->user_role == 'Admin'){
            $is_admin = 1;
            $user_role = $request->user_role;
        }  
        else{
            $is_admin = 0;
            $user_role = $request->role;
        }
            $fname = substr($request->first_name, 0, 1);
            $username1 = $school->school_code;
            $username2 = $request->last_name;
            $username = $username1 .'_'. $username2.$fname;

            $password = Hash::make($request->id_num);
            DB::table('users')->insert(
                ['school_id' => $request->school_id,
                 'last_name' => $request->last_name, 
                 'middle_initial' => $request->middle_i, 
                 'first_name' => $request->first_name, 
                 'user_role' => $user_role, 
                 'username' => $username, 
                 'is_admin' => $is_admin,
                 'password' => $password,
                 'status' => "For Log in", 
                ]
            );
    }

     public function editUser(Request $request)
    {
        $user = User::find($request->id);
        $school = School::all();

        echo '<label>User Description</label>
                    <select class="form-control"  name="user_role" onchange="CheckRole(this.value);">
                      <option disabled selected value> -- --  </option>
                      <option value="Admin">Admin</option>
                      <option value="others">Others</option>
                    </select>
                    <label>Status</label> <select class="form-control"  name="status">
                      <option disabled selected value> -- --  </option>
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                    <div class="form-group">
                    <input type="text" class="form-control" id="role" name="role"  style="display:none;"/>
                </div>
          
            <input type="hidden" name="uid" value="'.$request->id.'"></input>';      
    }


    public function updateUser(Request $request)
    {
         if($request->user_role == 'Admin'){
            $is_admin = 1;
            $user_role = $request->user_role;
        }  
        else{
            $is_admin = 0;
            $user_role = $request->role;
        }
            $username1 = $school->school_code;
            $username2 = $user_role;
            $username = $username1 .'_'. $username2;

        $user = User::find($request->id);
        $user->school_id = $request->school_id2;
        $user->name = $request->emp_name;
        $user->user_role = $user_role;
         $user->acad_prgram_id = $request->acad_prgram_id2;
        
        $user->save();

        return redirect()->route('index')->with('success', 'Record Updated');

    }
    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        if($user->status == "For Log in"){
            $user->delete();
        }else{
          return error_log(message);
        }
        
    }

    public function editAccount(Request $request)
    {
        $account = Account::find($request->id);
        echo '<label>Status Name</label> <input type="text" class="form-control" name="statusName" required value="'.$status->accred_status.'"></input>

            <input type="hidden" name="sid" value="'.$request->id.'"></input>';
        
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
