<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePost()
    {
        $postInfo=[
            'title' => 'Post title 1',
            "description"=>"Post description test",
            "content"=>"Post description content",
        ];

        $user = factory(User::class)->create();

        $post = new Post;
        $post->user_id = $user->id;
        $post->save();
        
        $response = $this->actingAs($user)
        ->json('POST', route("post-update",$post->id), $postInfo);
        $response->assertJson(["status"=>"success"]);
        $this->assertDatabaseHas('posts', $postInfo);
        $post->delete();
    }

    public function testCreatePostWithInvalidData(){
        $user = factory(User::class)->create();
    
        $post = new Post;
        $post->user_id = $user->id;
        $post->save();

        $postInfo=[
            'title' => 'Post title 3',
            "description"=>"Post description test",
        ];

        
        $response = $this->actingAs($user)
        ->json('POST', route("post-update",$post->id), $postInfo);
        $this->assertDatabaseMissing('posts', $postInfo);
        $post->delete();
    }

    public function testPostDelete(){
        $user = factory(User::class)->create();
        $postInfo=[
            'title' => 'Post title 1',
            "description"=>"Post description test",
            "content"=>"Post description content",
        ];
        $post = new Post;
        $post->user_id = $user->id;
        $post->update($postInfo);

        $response = $this->actingAs($user)
        ->json('DELETE', route("post-delete",$post->id));
        $response->assertJson(["status"=>"success"]);
        $this->assertDeleted("posts",$post);
    }


}
