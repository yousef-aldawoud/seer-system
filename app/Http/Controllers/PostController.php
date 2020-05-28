<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PostValidationRequest;
use Illuminate\Support\Facades\Validator;
use App\Post;
use Auth;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(["show"]);
        $this->middleware('moderator')->only(['validatePost']);
    }


    public function create(Request $request){
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect()->route("post-edit",$post->id);
    }

    public function edit(Post $post){
        if($post->status === "accepted" || $post->status === "validation"){
            abort(404);
        }
        return view("post-edit")->with(['post'=>$post]);
    }

    public function update(Post $post,CreatePostRequest $request){
        if($post->status === "accepted" || $post->status === "validation"){
            return ['status'=>"failed"];
        }
        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content;
        $post->save();
        return ["status"=>"success"];
    }
    
    public function showUserPosts() {
        return view('posts');
    }
    
    public function delete(Post $post){
        if(auth()->user()->id==$post->user_id || auth()->user()->hasRole("admin")){
            $post->delete();
            return ["status"=>"success"];
        }
        return ["status"=>"failed"];
    }
    
    public function userPosts(){
        return auth()->user()->posts()->paginate(10);
    }
    
    public function getReferences(Post $post){
        return $post->references()->get();
    }
    
    public function attachReference(Post $post, Request $request){
        if($request->reference_id !==null){
            $status = $post->references()->attach($request->reference_id);
            if($status){
                return ["status"=>"success"];
            }
        }
        return ["status"=>"failed"];
    }
    public function dettachReference(Post $post, Request $request){
        if($request->reference_id !==null){
            $status = $post->references()->detach($request->reference_id);
            if($status){
                return ["status"=>"success"];
            }
        }
        return ["status"=>"failed"];
    }

    public function changeStatus(Post $post,Request $request){
        if($post->status==="draft"){
            return ["status"=>"failed"];
        }
        $post->status = $request->status;
        $post->save();
        return ["status"=>"success"];
    }

    public function submitForValidation(Post $post){
        if($post->status !== "draft" && $post->status !== "rejected"){
            return ["status"=>"faild"];
        }
        $post->status = "validation";
        $post->save();
        return ["status"=>"success"];
    }

    public function show(Post $post){
        if($post->status === "accepted"){
            return view("post")->with(['post'=>$post]);
        }
        if(!Auth::check()){
            return abort(404);
        }

        if($post->user_id == auth()->user()->id){
            return view("post")->with(['post'=>$post]);
        }

        if($post->status === 'draft'){
            return abort(404);
        }

        $user = auth()->user();
        if($post->status === 'validation' && !$user->hasRole(["moderator","admin"])){
            return abort(404);
        }

        return view("post")->with(['post'=>$post]);
    }

    public function validatePost(Post $post, PostValidationRequest $request){
        if($post->status === 'rejected' || $post->status === 'draft'){
            return ['status'=>'failed'];
        }
        $post->status = $request->status;
        $post->save();
        return ['status'=>'success'];

    }

}
