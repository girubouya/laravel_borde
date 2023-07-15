<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Comment;

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

    //多対多リレーション(user_idとpost_id)
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

    //多対多リレーション(user_idとcomment_id)
    public function commentLikes(){
        return $this->belongsToMany(Comment::class,'likes','user_id','comment_id')->withTimestamps();
    }
    public function isLikeComment($commentId){
        return $this->commentLikes()->where('comment_id',$commentId)->exists();
    }
    public function LikeComment($commentId){
        if($this->isLikeComment($commentId)){

        }else{
            $this->commentLikes()->attach($commentId);
        }
    }
    public function unLikeComment($commentId){
        if($this->isLikeComment($commentId)){
            $this->commentLikes()->detach($commentId);
        }else{

        }
    }

}
