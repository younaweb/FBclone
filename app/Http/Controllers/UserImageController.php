<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use App\Http\Resources\UserImage as UserImageResource;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    public function store()
    {
        $data=request()->validate([
            'width'=>'',
            'height'=>'',
            'image'=>'',
            'location'=>'',
        ]);
        
        $image=$data['image']->store('user-images','public');
        Image::make($data['image'])
            ->fit($data['width'], $data['height'])
            ->save(storage_path('app/public/user-images/'.$data['image']->hashName()));
        // dd($image);

        $img=auth()->user()->images()->create([
            'path'=>$image,
            'width'=>$data['width'],
            'height'=>$data['height'],
            'location'=>$data['location'],
        ]);
                return new UserImageResource($img);
    }
}
