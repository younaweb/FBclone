<?php

namespace App\Http\Resources;
use App\Http\Resources\Friend as ResourceFriend;
use App\Models\Friend;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'data'=>[
                'type'=>'users',
                'user_id'=>$this->id,
                'attributes'=>[
                    'name'=>$this->name,
                    'friendship'=>new ResourceFriend(Friend::friendship($this->id)),
                ]
                ],
            'links'=>[
                'self'=>url('/users/'.$this->id)
            ]
        ];
    }
}
