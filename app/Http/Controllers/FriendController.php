<?php

namespace App\Http\Controllers;

use App\Http\Resources\Friend as ResourcesFriend;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function store()
    {
        $data=request()->validate([
            'friend_id'=>'required',
            'confirmed_at'=>'',
        ]);
        $data['user_id']=auth()->user()->id;
        $fr=Friend::create($data);
        return new ResourcesFriend($fr);
    }
}
