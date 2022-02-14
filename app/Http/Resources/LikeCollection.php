<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LikeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'like_count'=>$this->count(),
            'user_like_post'=>$this->collection->contains('id',auth()->user()->id),
            'links' => [
                'self' => url('/posts'),
            ]
        ];
    }
}
