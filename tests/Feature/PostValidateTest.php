<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Post;

class PostValidateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testValidateSubmittedPostReject()
    {
        $user = factory(User::class)->create();
        $user->assignRole("moderator");
        $post = new Post;
        $post->user_id = $user->id;
        $post->status = "validation";
        $post->save();
        $response = $this->actingAs($user)
        ->json('POST', route("post-validate",$post->id), ["status"=>"rejected"]);
        $response->assertJson(["status"=>"success"]);
        $response->assertStatus(200);
        $post = Post::find($post->id);
        echo $post->status; 
        $this->assertTrue($post->status === "rejected");
    }

    public function testValidateSubmittedPostAccept()
    {
        $user = factory(User::class)->create();
        $user->assignRole("moderator");
        $post = new Post;
        $post->user_id = $user->id;
        $post->status = "validation";
        $post->save();
        $response = $this->actingAs($user)
        ->json('POST', route("post-validate",$post->id), ["status"=>"accepted"]);
        $response->assertJson(["status"=>"success"]);
        $response->assertStatus(200);
        $post = Post::find($post->id);
        echo $post->status; 
        $this->assertTrue($post->status === "accepted");
    }

    public function testValidateDraftPost()
    {
        $user = factory(User::class)->create();
        $user->assignRole("moderator");
        $post = new Post;
        $post->user_id = $user->id;
        $post->status = "draft";
        $post->save();
        $response = $this->actingAs($user)
        ->json('POST', route("post-validate",$post->id), ["status"=>"rejected"]);
        $response->assertJson(["status"=>"failed"]);
        $response->assertStatus(200);

    }
}
