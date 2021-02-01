<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   public function login(Request $request)
    {   
        $input = $request->all();
        if($request->role == "staff"){
          
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
   
        if(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'])))
        {
            if(auth()->user()->status == "For Log in"){
                return redirect()->route('firstlogin');
            }else{
                return redirect()->route('accredIndex');
            }
        }else{
            return redirect()->route('staff')
                ->withErrors([
            'username' => "Credentials doesnt match our record!",
        ]);
        }
    }
    
    if($request->role = "alumni"){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
   
        if(auth()->guard('alumni')->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if(auth()->guard('alumni')->user()->user_role == "graduate"){
                return redirect()->route('alumniGraduate');
            }else{
                if(auth()->guard('alumni')->user()->remarks == "For Log in"){
                    return redirect()->route('firstloginAlumni');
                }else{
                    return redirect()->route('secretary');
                }
            }
        }else{
            return redirect()->route('alumni')
                ->withErrors([
            'email' => "Credentials doesnt match our record!",
        ]);
        }
    }
          
    }
    public function staffLogin()
    { 
        return view('auth.staffLogin');
    }
    public function alumniLogin()
    { 
        return view('auth.alumniLogin');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

   

}
