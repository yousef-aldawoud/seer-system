<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reference;
use App\Http\Requests\CreateReferenceRequest;
use App\Filters\ReferenceFilter;
use Auth;

class ReferenceController extends Controller
{

    public function create(CreateReferenceRequest $request){

        $details = [];
        $reference = new Reference;
        $details = $request->details;
        
        if($request->type === "book"){
            if($request->details['author']===null){
                return ["status"=>"failds","details"=>$request->details];
            }
            
        }
        
        if($request->type === "link"){
            if($request->link===null){
                return ["status"=>"faild"];
            }   
        }

        $reference->user_id = auth()->user()->id;
        $reference->title = $request->title;
        $reference->link = $request->details['link'];
        $reference->author = $request->details['author'];
        $reference->save();
        return ['status'=>"success","reference"=>$reference];
    }

    public function get(ReferenceFilter $filter){
        if(!Auth::check()){
            return Reference::filter($filter)->where("status","accepted")->paginate(10);
        }

        if(auth()->user()->hasRole("admin")||auth()->user()->hasRole("moderator")){
            return Reference::filter($filter)->paginate(10);
        }
        return Reference::filter($filter)
        ->where(function($query){
            $query->where("status","accepted")->orWhere([
                ['status',"=","validation"],
                ['user_id',"=",auth()->user()->id],
            ]);
        })
        ->paginate(10);
    }
}
