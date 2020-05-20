<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\User;
use App\UserActivation;
use App\Notifications\UserActivationNotification;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request){
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $this->sendVerifyLink($user);
        return redirect()->back()->with(['message'=>"Your account is registered please. Check your email for verification link."]);
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
}
