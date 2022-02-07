<?php

namespace App\Http\Controllers;

use App\Http\Resources\Friend as ResourcesFriend;
use App\Models\Friend;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'user_id' => '',

        ]);
        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json([], 404);
        }

        $friendRequest->update([
            'confirmed_at' => now(),
            'status' => 1
        ]);

        return new ResourcesFriend($friendRequest);
    }

    public function destroy()
    {
        $data = request()->validate([
            'user_id' => 'required',

        ]);
        try {
            $fr = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail()
                ->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json([], 404);
        }


        return response()->json([], 204);
    }
}
