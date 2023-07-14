<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'content',
        'user_id',
    ];

    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id');
    }

    public function like(){
        return $this->hasMany(Like::class,'post_id','id');
    }

    // public function likes(){
    //     return $this->belongsToMany(User::class,'likes','post_id','user_id');
    // }

}
