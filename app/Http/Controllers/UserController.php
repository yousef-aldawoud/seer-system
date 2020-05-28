<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\PasswordReset;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserActivation;
use App\Notifications\UserActivationNotification;
use Illuminate\Support\Str;
use Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->only(['login','register','loginView']);
        $this->middleware('auth')->only('logout');
    }

    public function register(RegisterUserRequest $request){
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $this->sendVerifyLink($user);
        return redirect()->back()->with(['message'=>"Your account is registered please. Check your email for verification link."]);
    }

    public function verify($token){
        $userActivation = UserActivation::where("token",$token)->first();
        $userActivation === null ? abort(404) : null;
        $user = $userActivation->user()->first();;
        $user->verified = true;
        $user->save();
        $userActivation->delete();
        return redirect('/');
    }

    public function sendVerifyLink(User $user){
        $user->activations()->delete();
        do{
            $code = Str::random(225); 
        }while(UserActivation::where('token',$code)->count()>0);
        $activation = new UserActivation;
        $activation->token = $code;
        $activation->user_id = $user->id;
        $activation->save();
        $user->notify(new UserActivationNotification());
    }
   
    public function login(Request $request){
        if(empty($request->email) || empty($request->password)){
            return redirect()->back()->with(['login-status'=>'your password or email is incorrect']);
        }
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            if(Auth::user()->hasRole("admin")){
                return redirect('/admin');
            }

            if(Auth::user()->disabled){
                Auth::logout();
                return redirect()->back()->with(['login-status'=>'your account has been disabled. Please contact us.']);
            }


            if(!Auth::user()->verified){
                Auth::logout();
                return redirect()->back()->with(['login-status'=>'you need to activate your account by the link sent to your email']);
            }

            return redirect('/');
        }

        return redirect()->back()->with(['login-status'=>'your password or email is incorrect']);
    }


    public function showPasswordReset($token){
        $passwordReset = PasswordReset::where('token',$token)->first() ;
        $passwordReset=== null ? abort(404) : null;
        return view('user.password-reset')->with(['token'=>$token]);
    }

    public function resetPassword($token,ResetPasswordRequest $request)
    {
        $passwordReset = PasswordReset::where('token',$token)->first() ;
        $passwordReset=== null ? abort(404) : null;
        if($request->password !== $request->password_confirm){
            return redirect()->back();
        }
        $user = $passwordReset->user()->first();
        $user->password = Hash::make($request->password);
        $user->verified = true;
        $user->save();
        $passwordReset->delete();
        return redirect('/');
    }

    public function loginView(){
        return view('login');
    }

    public function logout(){
        auth()->logout();
        return redirect("/");
    }
}
