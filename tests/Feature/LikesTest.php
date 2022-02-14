<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_like_a_post()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $post = Post::factory()->create(['id' => 123]);
        $response = $this->post('/api/posts/' . $post->id . '/like')->assertStatus(200);
        $this->assertCount(1, $user->likedPost);
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'likes',
                        'like_id' => 1,
                        'attributes' => [],
                    ],
                    'links' => [
                        'self' => url('/posts/123')
                    ]
                ]
            ],
            'links' => [
                'self' => url('/posts')
            ]

        ]);
    }



    /** @test */
    public function a_post_is_returned_with_his_likes()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $post = Post::factory()->create(['id' => 123, 'user_id' => $user->id]);
        $this->post('/api/posts/' . $post->id . '/like')->assertStatus(200);
        $response = $this->get('/api/posts')->assertStatus(200);
        $response->assertJson([
            'data' => [
                [


                    'data' => [
                        'type' => 'posts',
                        'post_id' => $post->id,
                        'attributes' => [
                            'likes' => [
                                'data' => [

                                    ['data' => [
                                        'type' => 'likes',
                                        'like_id' => 1,
                                        'attributes' => []

                                    ]
                                    ]
                                ],
                                'like_count' => 1,
                                'user_like_post' => true,
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
