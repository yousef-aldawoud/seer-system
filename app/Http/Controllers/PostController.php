<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PostValidationRequest;
use Illuminate\Support\Facades\Validator;
use App\Filters\PostFilter;
use App\Filters\ReferenceFilter;
use App\Post;
use App\Notifications\PostValidationNotification;
use App\PostValidationMessage;
use Auth;
use App\Reference;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(["show",'search','getPosts','getReferences']);
        $this->middleware('moderatorAndAnalyst')->only(['validatePost']);
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
        $read_time = sizeof(explode(" ",$request->content))/250;
        $post->read_time = intval($read_time)<=0?1:intval($read_time);
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
        if(auth()->user()->id != $post->user_id && !auth()->user()->hasRole(["admin","moderator","analyst"])){
            return abort(404);
        }

        if($request->reference_id !==null){
            $post->references()->attach($request->reference_id);
            return ["status"=>"success"];
        }
        return ["status"=>"failed"];
    }
    public function dettachReference(Post $post, Request $request){
        if(auth()->user()->id != $post->user_id && !auth()->user()->hasRole(["admin","moderator","analyst"])){
            return abort(404);
        }
        
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

        if($post->status === 'analysis' && !$user->hasRole(["admin","analyst","moderator"])){
            return abort(404);
        }

        return view("post")->with(['post'=>$post]);
    }

    public function search(Request $request){
        if (empty($request->q)){
            return redirect('/');
        }
        return view('search-result')->with(['searchQuery'=>$request->q]);
    }

    public function validatePost(Post $post, PostValidationRequest $request){
        if($post->status === 'draft'){
            return ['status'=>'failed'];
        }

        if($request->status === 'rejected'){
            if(empty($request->message)){
                return [
                    'status'=>'failed',
                    'errors'=>['message required']
                ];
            }
        }

        $postValidationMessage = null;
        if(!empty($request->message)){
            $postValidationMessage = new PostValidationMessage;
            $postValidationMessage->user_id = auth()->id();
            $postValidationMessage->message = $request->message;
            $postValidationMessage->status = $request->status;
            $postValidationMessage->post_id = $post->id;
            $postValidationMessage->save();
        }

        
        $post->status = $request->status;
        $post->save();
        $post->user()->first()->notify(new PostValidationNotification($post, $postValidationMessage));
        if($post->status === "accepted"){
            $references = $post->references()->get();
            foreach($references as $reference){
                $reference->status='accepted';
                $reference->save();
            }
        }
        return ['status'=>'success'];

    }

    public function getPosts(Request $request){
        $postFilter = new PostFilter($request);
        $referenceFilter = new ReferenceFilter($request);
        $references = Reference::filter($referenceFilter)->where('status','accepted')->get();
        $posts = Post::select('id','title','status','description','user_id','created_at','updated_at','read_time')
        ->filter($postFilter)->where("status",'accepted');
        
        if(Auth::check() && !$request->has("main")){;
            $posts->orWhere([
                ['status','=','draft'],
                ['user_id','=',auth()->user()->id],
            ]);

            if(auth()->user()->hasRole(['admin','moderator'])){
                $posts->orWhere('status','=','rejected')->orWhere('status','=','validation')->orWhere('status','=','analysis'); 
            }

            if(auth()->user()->hasRole(['admin','analyst'])){
                $posts->orWhere('status','=','analysis');
            }
        }
        $posts = $posts->paginate(10);
        foreach($references as $reference){
            foreach($reference->posts()->where('status','accepted')->get() as $refPost){
                if($posts->where('id',$refPost->id)->count()>=1){
                    continue;
                }
                $posts->push($refPost);
            }
        }
        $posts->map(function($post){
            $user=$post->user()->first();
            $post['rating']=$post->reviews()->avg('rating');
            $post['username'] = $user === null ?'noname':$user->name;
        });
        
        return  $posts;
    }

}
