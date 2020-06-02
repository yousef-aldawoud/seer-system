<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostReview;
use App\Http\Requests\PostReviewRequest;

class PostReviewController extends Controller
{

    public function create(Post $post, Request $request){
        if(PostReview::where([['user_id',auth()->id()],['post_id',$post->id]])->count()>=1){
            return ['status'=>'failed','errors'=>['duplicate reviews']];
        }
        $post->reviews()->create(
            [
                'user_id'=>auth()->id(),
                'rating'=>$request->rating,
                'comment'=>$request->comment,
            ]
        );
        return ['status'=>'success'];
    }
}
