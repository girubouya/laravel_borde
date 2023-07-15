<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function store($postId, Request $request){
        if($request->option === 'post'){
            Auth::user()->like($postId);
            $goodCount = Like::where('post_id',$postId)->count();
        }
        if($request->option === 'comment'){
            Auth::user()->LikeComment($postId);
            $goodCount = Like::where('comment_id',$postId)->count();
        }

        $param = [
            'goodCount'=>$goodCount,
        ];
        return response()->json($param);
    }

    public function destory($postId, Request $request){
        if($request->option==='post'){
            Auth::user()->unlike($postId);
            $goodCount = Like::where('post_id',$postId)->count();
        }
        if($request->option === 'comment'){
            Auth::user()->unLikeComment($postId);
            $goodCount = Like::where('comment_id',$postId)->count();
        }

        $param = [
            'goodCount'=>$goodCount,
        ];
        return response()->json($param);
    }
}
