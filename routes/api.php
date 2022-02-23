<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserImageController;
use App\Http\Controllers\UserPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->group(function(){
    Route::get('/auth-user',[AuthUserController::class,'show']);
    
    Route::apiResources([
        '/posts'=>PostController::class,
        '/posts/{post}/like'=>PostLikeController::class,
        '/posts/{post}/comment'=>PostCommentController::class,
        '/users'=>UserController::class,
        '/users/{user}/posts'=>UserPostController::class,
        '/friend-request'=>FriendController::class,
        '/friend-request-response'=>FriendRequestController::class,
        '/user-image'=>UserImageController::class,
    ]);

});