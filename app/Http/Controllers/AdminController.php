<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin')->except('dashboard');
        $this->middleware('moderator')->only('dashboard');
    }

    public function makeModerator(User $user){
        $user->assignRole("moderator");
        return ["status"=>"success"];
    }

    public function removeModerator(User $user){
        $user->removeRole("moderator");
        return ["status"=>"success"];
    }

    public function getUsers(UserFilter $filter){
        $users = User::filter($filter)->paginate(10);
        $users->map(function($user) use ($users){
            $user['admin'] = $user->hasRole("admin");
            $user['moderator'] = $user->hasRole("moderator");
            return $user;
        });
        return $users;
    }

    public function dashboard(){
        return view('admin.dashboard');
    }
}
