<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //良いねする処理
    //$postId = post_id/comment_id
    //$request = post/comment
    public function store($postId, Request $request){
        //良いねされたのが投稿された物だった場合
        if($request->option === 'post'){
            // likeテーブル(中間テーブル)にpost_idを登録
            Auth::user()->like($postId);
            // その投稿に良いねされている総数を取得
            $goodCount = Like::where('post_id',$postId)->count();
        }
        //良いねされたのがコメントだった場合
        if($request->option === 'comment'){
             // likeテーブル(中間テーブル)にcomment_idを登録
            Auth::user()->LikeComment($postId);
             // その投稿に良いねされている総数を取得
            $goodCount = Like::where('comment_id',$postId)->count();
        }

        $param = [
            'goodCount'=>$goodCount,
        ];
        //JSON形式でデータを返す
        return response()->json($param);
    }

    // 良いねを外す処理
    public function destory($postId, Request $request){
         //良いねされたのが投稿された物だった場合
        if($request->option==='post'){
             // likeテーブル(中間テーブル)からpost_idを削除
            Auth::user()->unlike($postId);
            // その投稿に良いねされている総数を取得
            $goodCount = Like::where('post_id',$postId)->count();
        }
        //良いねされたのがコメントだった場合
        if($request->option === 'comment'){
            // likeテーブル(中間テーブル)からcomment_idを削除
            Auth::user()->unLikeComment($postId);
            // その投稿に良いねされている総数を取得
            $goodCount = Like::where('comment_id',$postId)->count();
        }

        $param = [
            'goodCount'=>$goodCount,
        ];
        //JSON形式でデータを返す
        return response()->json($param);
    }
}
