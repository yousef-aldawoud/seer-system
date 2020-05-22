<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Support\Facades\Validator;
use App\Post;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    public function create(Request $request){
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect()->route("post-edit",$post->id);
    }

    public function edit(Post $post){
        return view("post-edit")->with(['post'=>$post]);
    }

    public function update(Post $post,CreatePostRequest $request){
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
        if(auth()->user()->id==$post->user_id){
            $post->delete();
            return ["status"=>"success"];
        }
        return ["status"=>"failed"];
    }
    

}
