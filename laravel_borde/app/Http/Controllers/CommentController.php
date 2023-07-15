<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index(){

    }

    public function store(CommentRequest $request){
        // ログインしていればコメント出来る
        if(Auth::user() === null){
            $message = 'ログインすればコメントできます';
            $post_id = $request->post_id;
        }else{
            // コメントしている投稿ID取得
            $post_id = $request->post_id;
            // userId取得
            $user_id = Auth::id();

            $comments = [
                'user_id'=>$user_id,
                'post_id'=>$post_id,
                'comment'=>$request->comment,
            ];
            $comment = new Comment;
            //commentテーブルにデータを追加
            $comment->fill($comments)->save();
            $message = '';
        }
        return redirect('/posts/' . $post_id)->with(compact('message'));
    }

    public function edit(Request $request){
        $loginUser = Auth::user();
        // 編集するコメントIDを取得
        $comment = Comment::find($request->comment_id);
        return view('posts.comment_edit',compact('comment','loginUser'));
    }

    public function update(Request $request){
        // 編集するコメントIDを取得
        $comment = Comment::find($request->comment_id);
        // commentテーブルの内容を更新
        $comment->update([
            'comment'=>$request->content,
        ]);
        return redirect('/posts/'.$request->post_id);
    }

    public function delete(Request $request){
        // 選択しているコメントIDを取得して削除
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        return redirect('/posts/'.$request->post_id);
    }
}
