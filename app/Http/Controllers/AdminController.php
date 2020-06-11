<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin')->except('dashboard');
        $this->middleware('moderatorAndAnalyst')->only('dashboard');
    }

    public function makeModerator(User $user){
        if($user->hasRole('moderator')){
            return ['status'=>'failed','error'=>['Already moderator']];
        }
        $user->assignRole("moderator");
        return ["status"=>"success"];
    }

    public function makeAnalyst(User $user){
        if($user->hasRole('analyst')){
            return ['status'=>'failed','error'=>['Already analyst']];
        }
        $user->assignRole("analyst");
        return ["status"=>"success"];
    }

    public function removeModerator(User $user){
        $user->removeRole("moderator");
        return ["status"=>"success"];
    }

    public function removeAnalyst(User $user){
        $user->removeRole("analyst");
        return ["status"=>"success"];
    }

    public function getUsers(UserFilter $filter){
        $users = User::filter($filter)->paginate(10);
        $users->map(function($user) use ($users){
            $user['admin'] = $user->hasRole("admin");
            $user['moderator'] = $user->hasRole("moderator");
            $user['analyst'] = $user->hasRole("analyst");
            return $user;
        });
        return $users;
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function disableUser(User $user){
        if($user->disabled || $user->hasRole('admin')){
            return ['status'=>'failed'];
        }
        $user->disabled = true;
        $user->save();
        return ['status'=>'success'];
    }

    public function enableUser(User $user){
        if(!$user->disabled || $user->hasRole('admin')){
            return ['status'=>'failed'];
        }
        $user->disabled = false;
        $user->save();
        return ['status'=>'success'];
    }
}
