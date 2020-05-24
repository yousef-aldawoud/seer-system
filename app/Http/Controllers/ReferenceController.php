<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reference;
use App\Http\Requests\CreateReferenceRequest;

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

        $reference->title = $request->title;
        $reference->link = $request->details['link'];
        $reference->author = $request->details['author'];
        $reference->save();
        return ['status'=>"success","reference"=>$reference];
    }

    public function get(){
        return Reference::paginate(10);
    }
}
