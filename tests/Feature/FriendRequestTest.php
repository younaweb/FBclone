<?php

namespace Tests\Feature;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FriendRequestTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_send_friend_request()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->actingAs($user,'api');
        $friend=User::factory()->create();
        $response=$this->post('/api/friend-request',[
            'friend_id'=>$friend->id,
        ])
        ->assertStatus(201);
        $fr=Friend::first();
        $this->assertNotNull($fr);
        $this->assertEquals($friend->id,$fr->friend_id);
        $this->assertEquals($user->id,$fr->user_id);
        $response->assertJson([
            'data'=>[
                'type'=>'friend-request',
                'friend_id'=>$fr->id,
                'attributes'=>[
                    'confirmed_at'=>null,
                ]
                ],
                'links'=>[
                    'self'=>url('/users/'.$friend->id)
                ]
        ]);
    }

    /** @test */
    public function friend_request_can_be_accepted()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->actingAs($user,'api');
        $anotherUser=User::factory()->create();
        $response=$this->post('/api/friend-request',[
            'friend_id'=>$anotherUser->id,
        ])
        ->assertStatus(201);
        $this->actingAs($anotherUser,'api');
        $response=$this->post('/api/friend-request-response',[
            
            'user_id'=>$user->id,
            'friend_id'=>$anotherUser->id,
        ])
        ->assertStatus(200);
        $friendreq=Friend::first();
        $this->assertNotNull($friendreq->confirmed_at);
        $response->assertJson([
            'data'=>[
                'type'=>'friend-request',
                'friend_id'=>$friendreq->id,
                'attributes'=>[
                    'confirmed_at'=>$friendreq->confirmed_at->diffForHumans(),
                ]
                ],
                'links'=>[
                    'self'=>url('/users/'.$anotherUser->id)
                ]
        ]);
    }
    /** @test */
    public function friend_request_can_be_ignored()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->actingAs($user,'api');
        $anotherUser=User::factory()->create();
        $response=$this->post('/api/friend-request',[
            'friend_id'=>$anotherUser->id,
        ])
        ->assertStatus(201);
        $this->actingAs($anotherUser,'api');

        $response=$this->delete('/api/friend-request-response/hammasouya',[
            
            'user_id'=>$user->id,
        ])
        ->assertStatus(204)
        ->assertNoContent();
        $friendreq=Friend::first();
        $this->assertNull($friendreq);
        
        
     
    }
    /** @test */
    public function only_receipist_can_ignore_a_friend_request()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->actingAs($user,'api');
        $anotherUser=User::factory()->create();
        $response=$this->post('/api/friend-request',[
            'friend_id'=>$anotherUser->id,
        ])

        ->assertStatus(201);
        $user2=User::factory()->create();
        $this->actingAs($user2,'api');
        $response=$this->delete('/api/friend-request-response/hammasouya',[
            
            'user_id'=>$user->id,
        ])
        ->assertStatus(404);
        
        
        
     
    }


    /** @test */
    public function a_friendship_is_retreived_when_fetching_the_profile()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->actingAs($user,'api');
        $anotherUser=User::factory()->create();
        $friendRequest=Friend::create([
            'user_id'=>$user->id,
            'friend_id'=>$anotherUser->id,
            'confirmed_at'=>now()->subDay(),
            'status'=>1
        ]);

        $response=$this->get('/api/users/'.$anotherUser->id);
        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $anotherUser->id,
                'attributes' => [
      
                  'name' => $anotherUser->name,
                  'friendship'=>[
                      'data'=>[
                          'friend_id'=>$friendRequest->id,
                          'attributes'=>[
                              'confirmed_at'=>'1 day ago',
                          ]
                      ]
                  ]
      
                ]
      
              ],
              'links' => [
                'self' => url('/users/' . $anotherUser->id)
              ]

        ]);

    }


    /** @test */
    public function an_inverse_friendship_is_retreived_when_fetching_the_profile()
    {
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->actingAs($user,'api');
        $anotherUser=User::factory()->create();
        $friendRequest=Friend::create([
            'friend_id'=>$user->id,
            'user_id'=>$anotherUser->id,
            'confirmed_at'=>now()->subDay(),
            'status'=>1
        ]);

        $response=$this->get('/api/users/'.$anotherUser->id);
        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $anotherUser->id,
                'attributes' => [
      
                  'name' => $anotherUser->name,
                  'friendship'=>[
                      'data'=>[
                          'friend_id'=>$friendRequest->id,
                          'attributes'=>[
                              'confirmed_at'=>'1 day ago',
                          ]
                      ]
                  ]
      
                ]
      
              ],
              'links' => [
                'self' => url('/users/' . $anotherUser->id)
              ]

        ]);

    }
    
    
    
}
