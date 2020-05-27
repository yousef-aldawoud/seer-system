<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function makeModerator(User $user){
        $user->assignRole("moderator");
        return ["status"=>"success"];
    }

    public function getUsers(UserFilter $filter){
        return User::filter($filter)->paginate(10);
    }
}
