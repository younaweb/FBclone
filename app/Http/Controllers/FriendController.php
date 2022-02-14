<?php

namespace App\Http\Controllers;

use App\Http\Resources\Friend as ResourcesFriend;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'friend_id' => 'required',
            'confirmed_at' => '',
        ]);


        User::findOrFail($data['friend_id'])->friends()->syncWithoutDetaching(auth()->user());
        return new ResourcesFriend(
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $data['friend_id'])
                ->first()
        );
    }
}
