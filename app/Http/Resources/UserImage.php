<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserImage extends JsonResource
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
            'data' => [
                'type' => 'user-images',
                'user_image_id' => $this->id,
                'attributes' => [
                    'width' => $this->width,
                    'height' => $this->height,
                    'location' => $this->location,
                    'path' => url('storage/'.$this->path),

                ]
            ],
            'link' => [
                'self' => url('/users/' . $this->user_id)
            ]
        ];
    }
}
