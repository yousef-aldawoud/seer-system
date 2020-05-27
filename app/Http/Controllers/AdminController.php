<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function makeModerator(User $user){
        $user->assignRole("moderator");
        return ["status"=>"success"];
    }
}
