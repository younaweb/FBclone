<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as ResourcesUser;


class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data'=>[
                'type'=>'posts',
                'post_id'=>$this->id,
                'attributes'=>[
                    'posted_by'=>new ResourcesUser($this->user),
                    'likes'=>new LikeCollection($this->likes),
                    'body'=>$this->body,
                    'image'=>$this->image,
                    'posted_at'=>$this->created_at->diffForHumans(),
                ]
                ],
            'links'=>[
                'self'=>url('/posts/'.$this->id),
            ]
        ];
    }
}
