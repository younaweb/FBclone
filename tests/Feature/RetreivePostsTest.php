<?php

namespace Tests\Feature;

use App\Models\Friend;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetreivePostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_retreive_posts()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $anotherUser = User::factory()->create();

        $posts = Post::factory(2)->create(['user_id' => $anotherUser->id]);
        Friend::create([
            'user_id'=>$user->id,
            'friend_id'=>$anotherUser->id,
            'status'=>1,
            'confirmed_at'=>now()
        ]);
        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $posts->first()->id,
                            'attributes' => [

                                'body' => $posts->first()->body,
                                'image'=>url($posts->first()->image),
                                'posted_at' => $posts->first()->created_at->diffForHumans(),
                            ]
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'posts',
                            'post_id' => $posts->last()->id,
                            'attributes' => [

                                'body' => $posts->last()->body,
                                'image'=>url($posts->last()->image),
                                'posted_at' => $posts->last()->created_at->diffForHumans(),
                            ]
                        ]
                    ],
                ],

                'links' => [
                    'self' => url('/posts')
                ]

            ]);
    }




    /** @test */
    public function a_user_can_retreive_only_their_posts()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $posts = Post::factory()->create();
        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertExactJson([
                'data' => [],
                'links' => [
                    'self' => url('/posts'),
                ]

            ]);
    }
}
