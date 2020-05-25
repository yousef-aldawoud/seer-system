<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Reference;

class ReferenceTest extends TestCase
{
    public function testCreateReference()
    {
        $referenceInfo=[
            'title' => 'book 1',
            "details"=>[
                'title'=>'book 1',
                'author'=>'author 1',
                'link'=>''
            ],
            "type"=>"book",
        ];
        
        $reference=[
            'title' => 'book 1',
            'author'=>'author 1',
            "type"=>"book",
        ];

        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)
        ->json('POST', route("reference-create"), $referenceInfo);
        $response->assertJson(["status"=>"success"]);
        $this->assertDatabaseHas('references', $reference);
        $ref = Reference::first();
        $ref ?? $ref->delete();
    }
}
