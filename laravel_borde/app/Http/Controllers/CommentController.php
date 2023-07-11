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
        if(Auth::user() === null){
            $message = 'ログインすればコメントできます';
            $post_id = $request->post_id;
        }else{
            $post_id = $request->post_id;
            $user_id = Auth::id();

            $comments = [
                'user_id'=>$user_id,
                'post_id'=>$post_id,
                'comment'=>$request->comment,
            ];
            $comment = new Comment;
            $comment->fill($comments)->save();
            $message = '';
        }
        return redirect('/posts/' . $post_id)->with(compact('message'));
    }

    public function edit(Request $request){
        $loginUser = Auth::user();
        $comment = Comment::find($request->comment_id);
        $comment->load('post');
        return view('posts.comment_edit',compact('comment','loginUser'));
    }

    public function update(Request $request){
        $comment = Comment::find($request->comment_id);
        $comment->update([
            'comment'=>$request->content,
        ]);
        return redirect('/posts/'.$request->post_id);
    }

    public function delete(Request $request){
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        return redirect('/posts/'.$request->post_id);
    }
}
