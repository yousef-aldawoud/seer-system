<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostReview;
use App\Http\Requests\PostReviewRequest;

class PostReviewController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except('reviews');
    }

    public function create(Post $post, PostReviewRequest $request){
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

    public function reviews(Post $post){
        $reviews = $post->reviews()->paginate(10);
        $reviews->map(function($review){
            $user=$review->user()->first();
            $review['username'] = $user === null ?'noname':$user->name;
        });
        return $reviews;
    }

    public function update(PostReview $review, PostReviewRequest $request){
        if($review->user_id == auth()->id()){
            $review->comment = $request->comment;
            $review->rating = $request->rating;
            $review->save();
            return ['status'=>'success'];
        }
        return ['status'=>'failed'];
    }

    public function getUserReview(Post $post){
        $review = $post->reviews()->where("user_id",auth()->id())->first();
        return $review ?? null;
    }

    public function delete(PostReview $review){
        if($review->user_id == auth()->id() || auth()->user()->hasRole("admin")){
            $review->delete();
            return ['status'=>'success'];
        }
        return ['status'=>'failed'];
    }
}
