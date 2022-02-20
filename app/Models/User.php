<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at','Desc');
    }
    public function friends()
    {
        return $this->belongsToMany(User::class,'friends','friend_id','user_id');
    }
    public function likedPost()
    {
        return $this->belongsToMany(Post::class,'likes','user_id','post_id');
    }
    public function images()
    {
        return $this->hasMany(UserImage::class);
    }
    public function coverImage()
    {
        return $this->hasOne(UserImage::class)
        ->orderByDesc('id')
        ->where('location','cover')
        ->withDefault(function($userimg){
            $userimg->path='user-images/defaultcover.jpg';
        });
    }
    public function profileImage()
    {
        return $this->hasOne(UserImage::class)
        ->orderByDesc('id')
        ->where('location','profile')
        ->withDefault(function($userimg){
            $userimg->path='user-images/defaultprofile.png';
        });
    }
}
