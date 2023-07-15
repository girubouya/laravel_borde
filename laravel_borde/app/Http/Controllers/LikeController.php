<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function store($postId, Request $request){
        Auth::user()->like($postId);
        $goodCount = Like::where('post_id',$postId)->count();
        $param = [
            'goodCount' =>$goodCount,
            'dog'=>$request->dog,
        ];

        return response()->json($param);
    }

    public function storeComment($commentId){
        Auth::user()->LikeComment($commentId);
        $goodCount = Like::where('comment_id',$commentId)->count();
        $param = [
            'goodCount'=>$goodCount,
        ];

        return response()->json($param);
    }

    public function destory($postId){
        Auth::user()->unlike($postId);
        $goodCount = Like::where('post_id',$postId)->count();
        $param = [
            'goodCount' =>$goodCount
        ];

        return response()->json($param);
    }

    public function destroyComment($commentId){
        Auth::user()->unLikeComment($commentId);
        $goodCount = Like::where('comment_id',$commentId)->count();
        $param = [
            'goodCount'=>$goodCount,
        ];

        return response()->json($param);
    }
}
