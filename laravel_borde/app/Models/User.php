<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;

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
        'password' => 'hashed',
    ];

    //多対多リレーション
    public function likes(){
        return $this->belongsToMany(Post::class,'likes','user_id','post_id')->withTimestamps();
    }
    //この投稿に対して既にいいねしてるかを判別する
    public function isLike($postId){
        return $this->likes()->where('post_id',$postId)->exists();
    }
    //良いねしてなければ良いねする
    public function like($postId){
        if($this->isLike($postId)){
            //いいねしていれば何もしない
        }else{
            $this->likes()->attach($postId);
        }
    }
    //良いねしてたら外す
    public function unlike($postId){
        if($this->isLike($postId)){
            $this->likes()->detach($postId);
        }else{

        }
    }

}
