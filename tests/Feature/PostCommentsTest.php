<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCommentsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_comment_on_a_post()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $post = Post::factory()->create(['id' => 123]);

        $response = $this->post('/api/posts/' . $post->id . '/comment', [
            'body' => 'great comment'
        ])->assertStatus(200);
        $comment = Comment::first();

        $this->assertCount(1, Comment::all());
        $this->assertEquals($user->id, $comment->user->id);
        $this->assertEquals(123, $comment->post_id);
        $this->assertEquals('great comment', $comment->body);
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'comments',
                        'comment_id' => 1,
                        'attributes' => [
                            'commented_by' => [
                                'data' => [
                                    'user_id' => $user->id,
                                    'attributes' => [
                                        'name' => $user->name,
                                    ]
                                ]
                            ],
                            'body' => $comment->body,
                            'commented_at' => $comment->created_at->diffForHumans(),
                        ],
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
    public function a_post_is_returned_with_his_comments()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $post = Post::factory()->create(['id' => 123, 'user_id' => $user->id]);
        $this->post('/api/posts/' . $post->id . '/comment', [
            'body' => 'great one comment'
        ])->assertStatus(200);
        $response = $this->get('/api/posts')->assertStatus(200);
        $comment = Comment::first();
        $response->assertJson([
            'data' => [
                [


                    'data' => [
                        'type' => 'posts',
                        'post_id' => $post->id,
                        'attributes' => [
                            'comments' => [
                                'data' => [
                                    [
                                        'data' => [
                                            'type' => 'comments',
                                            'comment_id' => 1,
                                            'attributes' => [
                                                'commented_by' => [
                                                    'data' => [
                                                        'user_id' => $user->id,
                                                        'attributes' => [
                                                            'name' => $user->name,
                                                        ]
                                                    ]
                                                ],
                                                'body' => $comment->body,
                                                'commented_at' => $comment->created_at->diffForHumans(),
                                            ],
                                        ],
                                        'links' => [
                                            'self' => url('/posts/123')
                                        ]
                                    ]
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
