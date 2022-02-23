<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserImageTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function a_user_can_upload_image()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $file = UploadedFile::fake()->image('userimg.jpg');

        $response = $this->post('/api/user-image', [
            'width' => 600,
            'height' => 870,
            'location' => 'cover',
            'image' => $file,
        ])->assertStatus(201);

        Storage::disk('public')->assertExists('user-images/' . $file->hashName());
        $userImage = UserImage::first();
        $this->assertEquals('user-images/' . $file->hashName(), $userImage->path);
        $this->assertEquals('600', $userImage->width);
        $this->assertEquals('870', $userImage->height);
        $this->assertEquals('cover', $userImage->location);
        $response->assertJson([
            'data' => [
                'type' => 'user-images',
                'user_image_id' => $userImage->id,
                'attributes' => [
                    'width' => $userImage->width,
                    'height' => $userImage->height,
                    'location' => $userImage->location,
                    'path' => url($userImage->path),

                ]
            ],
            'link' => [
                'self' => url('/users/' . $user->id)
            ]
        ]);
    }


    /** @test */
    public function user_is_returned_with_his_images()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $file = UploadedFile::fake()->image('userimg.jpg');



        $this->post('/api/user-image', [
            'width' => 600,
            'height' => 870,
            'location' => 'cover',
            'image' => $file,
        ])->assertStatus(201);

        $this->post('/api/user-image', [
            'width' => 600,
            'height' => 870,
            'location' => 'profile',
            'image' => $file,
        ])->assertStatus(201);
$response=$this->get('/api/users/'.$user->id);

        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $user->id,
                'attributes' => [
                    'cover_image' => [
                        'data' => [
                            'type' => 'user-images',
                            'user_image_id' => 1,
                            'attributes' => []
                        ]
                    ],
                    'profile_image' => [
                        'data' => [
                            'type' => 'user-images',
                            'user_image_id' => 2,
                            'attributes' => []
                        ]
                    ],
                ]
            ]

        ]);
    }
}
