<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\{Hash,Auth,Input};
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use DB;
use App\Role;
use App\Permission;
use App\User;
//use Modules\User\Entities\User;
use Modules\Accreditation\Entities\School;
use Modules\User\Http\Controllers\Account;

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
    public function firstlogin()
    {
        return view('user::firstlogin');
    }

    public function account_dtb($id){
         $users = User::join('schools', 'schools.id', 'users.school_id')
          ->select('*','users.id as u_id')
          ->get();
         
         return DataTables::of($users)
            ->addColumn('actions', function($users) {
                    return '
                        <a class="btn btn-secondary btn-sm edit" title="View" href="'.route("userDetail", $users->u_id).'"><i class="fa fa-eye"></i>
                        </a>
                        <button class="btn btn-danger btn-sm destroy" title="Remove" userid="'.$users->u_id.'"><i class="fa fa-trash"></i>
                        </button>
                        ';
            })
            ->addColumn('user_role', function($users) {
                $roles = DB::table('users_roles')
                    ->join('roles','roles.id','users_roles.role_id')
                    ->where('user_id', $users->u_id)->first();
                    $list = "";
                    if(!empty($roles)){
                    $list = $roles->role_name;
                    }
                return $list;
        })
            ->rawColumns(['actions','user_role'])
            ->make(true);
            return view('user::index', compact('users'));
    }

    public function addUser(){
        $user = new User;
        $nrole = new Role;
        $roles = Role::all();
        $permissions = Permission::all();
        
        $listPermission = Permission::all()->pluck('permission_name')->unique();
     
        $school = School::all();
        return view('user::add-user', compact('school','roles','permissions','user','nrole','listPermission'));
    }
    public function userDetail($id){
        $user = User::join('users_roles','users_roles.user_id','users.id')->join('roles','roles.id','users_roles.role_id')->join('schools','schools.id','users.school_id')->where('users_roles.user_id',$id)->select('*','users.id as u_id')->first();
        $permissions =  DB::table('users_permissions')->join('permissions','permissions.id','users_permissions.permission_id')->where('users_permissions.user_id',$id)->get();
        return view('user::view-user', compact('permissions','user'));
    }
    public function userEdit($id){
        $roles = Role::all();
        $permissions = Permission::all();
        $school = School::all();
        $user = User::join('users_roles','users_roles.user_id','users.id')->join('roles','roles.id','users_roles.role_id')->join('schools','schools.id','users.school_id')->where('users_roles.user_id',$id)->first();
        $listPermission = Permission::all()->pluck('permission_name')->unique();
        $userPermission = DB::table('users_permissions')->join('permissions','permissions.id','users_permissions.permission_id')->where('users_permissions.user_id',$id)->pluck('permission_id')->unique();
        
        return view('user::edit-user', compact('permissions','user','userPermission','roles','listPermission','school'));
    }
     public function createUser(Request $request){
        $school = School::find($request->school_id);
        $rolename = DB::table('roles')->where('id',$request->role)->first();
        // $password = md5( $request->id_num .$salt);
            $fname = substr($request->first_name, 0, 1);
            $username1 = $school->school_code;
            $username2 = $request->last_name;
            $username = $username1 .'_'. $username2.$fname;

            $password = Hash::make($username2);
            $user = new User;
            $user->school_id = $request->school_id;
            $user->last_name = $request->last_name; 
            $user->middle_initial = $request->middle_i; 
            $user->first_name = $request->first_name; 
            $user->user_role = $rolename->role_name;
            $user->username = $username;
            $user->is_admin = 0;
            $user->password = $password;
            $user->status = "For Log in"; 
            $user->save();

            $user_id = $user->id; 
            //add Permission
            
            $permission = $request->permission;
            $N = count($permission);
            for($i=0; $i < $N; $i++)
            {
                 $var1 = $permission[$i];
                 DB::table('users_permissions')->insert(
                    ['user_id' => $user_id,
                     'permission_id' => $var1,  
                    ]
                );
            }

            //add user Role
            $role = $request->role;
            
                 DB::table('users_roles')->insert(
                    ['user_id' => $user_id,
                     'role_id' => $role,  
                    ]
                );
            return redirect()->route('userlist')->with('success', 'User Successfully Added!');

    }
    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
   
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
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->status = "Active";
        $user->save();

        return redirect()->route('accredIndex')->with("success","");
    }
    public function updateUser(Request $request)
    {
        $rolename = DB::table('roles')->where('id',$request->role)->first();
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $user->school_id = $request->school_id;
        $user->last_name = $request->last_name;
        $user->middle_initial = $request->middle_i;
        $user->first_name = $request->first_name;
        $user->user_role = $rolename->role_name;
        $user->save();

        //add Permission
        DB::table('users_permissions')->where('user_id',$user_id)->delete();
        $permission = $request->permission;
        $N = count($permission);
        for($i=0; $i < $N; $i++)
        {
             $var1 = $permission[$i];
             DB::table('users_permissions')->insert(
                ['user_id' => $user_id,
                 'permission_id' => $var1,  
                ]
            );
        }

        //add user Role
        DB::table('users_roles')->where('user_id',$user_id)->delete();
        $role = $request->role;
        
             DB::table('users_roles')->insert(
                ['user_id' => $user_id,
                 'role_id' => $role,  
                ]
            );

        return redirect()->route('userlist')->with('success', 'Record Updated');

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
