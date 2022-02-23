<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostToTimeLineTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $response = $this->post('/api/posts', [
            
                    'body' => 'Testing body',
                
            ]
        );
        $post = Post::first();
        $this->assertEquals($user->id, $post->user_id);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                        'posted_by' => [
                            'data' => [
                                'attributes' => [
                                    'name' => $user->name,
                                ]
                            ]
                        ],
                        'body' => $post->body,
                    ]
                ],
                'links' => [
                    'self' => url('/posts/' . $post->id)
                ]

            ]);
    }




    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }




    /** @test */
    public function a_user_can_post_a_post_with_image()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $file = UploadedFile::fake()->image('postimg.jpg');

        $response = $this->post('/api/posts', [
                    'body'=>'post body',
                    'image'=>$file,
                    'width'=>100,
                    'height'=>100,
                
            ]
        )->assertStatus(201);
        Storage::disk('public')->assertExists('post-images/' . $file->hashName());

        $post = Post::first();
        
        $response->assertJson([
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                      
                        'body' => $post->body,
                        'image'=>url($post->image),
                    ]
                ]

            ]);
    }
}
