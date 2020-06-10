<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;

class PostReviewTest extends TestCase
{
    public function testCreateReview()
    {
        $postInfo=[
            'title' => 'Post title 1',
            "description"=>"Post description test",
            "content"=>"Post description content",
        ];

        $postReviewInfo = [
            'rating'=>4,
            'comment'=>'Great post',
        ];

        $user = factory(User::class)->create();
        $reviewer = factory(User::class)->create();

        $post = new Post;
        $post->user_id = $user->id;
        $post->title = $postInfo['title'];
        $post->description = $postInfo['description'];
        $post->content = $postInfo['content'];
        $post->save();
        $response = $this->actingAs($reviewer)
        ->json('POST', route("post-review-create",$post->id), $postReviewInfo);
        $this->assertDatabaseHas('post_reviews', $postReviewInfo);
        $post->reviews()->delete();
        $post->delete();

        
    }

    public function testDuplicateReview()
    {
        $postInfo=[
            'title' => 'Post title 1',
            "description"=>"Post description test",
            "content"=>"Post description content",
        ];

        $postReviewInfo = [
            'rating'=>4,
            'comment'=>'Great post',
        ];

        $user = factory(User::class)->create();
        $reviewer = factory(User::class)->create();

        $post = new Post;
        $post->user_id = $user->id;
        $post->title = $postInfo['title'];
        $post->description = $postInfo['description'];
        $post->content = $postInfo['content'];
        $post->save();
        $this->actingAs($reviewer)
        ->json('POST', route("post-review-create",$post->id), $postReviewInfo);
        $this->actingAs($reviewer)
        ->json('POST', route("post-review-create",$post->id), $postReviewInfo);
        $reviewCount = $post->reviews()->where('user_id',$reviewer->id)->count();
        $this->assertTrue($reviewCount === 1);
        $post->reviews()->delete();
        $post->delete();
    }

    public function testChangeReview()
    {
        $postInfo=[
            'title' => 'Post title 1',
            "description"=>"Post description test",
            "content"=>"Post description content",
        ];

        $postReviewInfo = [
            'rating'=>4,
            'comment'=>'Great post',
        ];

        $user = factory(User::class)->create();
        $reviewer = factory(User::class)->create();
        $postReviewInfo['user_id']=$reviewer->id;
        $post = new Post;
        $post->user_id = $user->id;
        $post->title = $postInfo['title'];
        $post->description = $postInfo['description'];
        $post->content = $postInfo['content'];
        $post->save();
        $review = $post->reviews()->create($postReviewInfo);
        $postReviewInfo['comment'] = 'not good';
        $postReviewInfo['rating'] = 1;
        $this->actingAs($reviewer)
        ->json('POST', route("post-review-update",$review->id), $postReviewInfo);
        $this->assertDatabaseHas('post_reviews', $postReviewInfo);
        $post->reviews()->delete();
        $post->delete();
    }

    public function testDeleteReview()
    {

        $user = factory(User::class)->create();
        $reviewer = factory(User::class)->create();
        $postInfo=[
            'title' => 'Post title 1',
            "description"=>"Post description test",
            "content"=>"Post description content",
        ];
        $postReviewInfo = [
            'rating'=>4,
            'comment'=>'Great post',
        ];
        $post = new Post;
        $post->user_id = $user->id;
        $post->update($postInfo);
        $post->save();
        
        $postReviewInfo['user_id']=$reviewer->id;
        $review = $post->reviews()->create($postReviewInfo);
        $route = route("post-review-delete",$review->id);
        $response = $this->actingAs($reviewer)
        ->json('DELETE', $route);
        $response->assertJson(["status"=>"success"]);
        $this->assertDeleted("post_reviews",["id"=>$review->id]);

    }

    public function testDeleteByAdminReview()
    {

        $user = factory(User::class)->create();
        $reviewer = factory(User::class)->create();
        $postInfo=[
            'title' => 'Post title 1',
            "description"=>"Post description test",
            "content"=>"Post description content",
        ];
        $postReviewInfo = [
            'rating'=>4,
            'comment'=>'Great post',
        ];
        $user->assignRole("admin");
        $post = new Post;
        $post->user_id = $user->id;
        $post->update($postInfo);
        $post->save();
        
        $postReviewInfo['user_id']=$reviewer->id;
        $review = $post->reviews()->create($postReviewInfo);
        $route = route("post-review-delete",$review->id);
        $response = $this->actingAs($user)
        ->json('DELETE', $route);
        $response->assertJson(["status"=>"success"]);
        $this->assertDeleted("post_reviews",["id"=>$review->id]);

    }

}