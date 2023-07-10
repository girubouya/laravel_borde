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
        $post_id = $request->post_id;
        $user_id = Auth::id();

        $comments = [
            'user_id'=>$user_id,
            'post_id'=>$post_id,
            'comment'=>$request->comment,
        ];
        $comment = new Comment;
        $comment->fill($comments)->save();

        return redirect('/posts/' . $post_id);
    }

    public function edit($id){
        $loginUser = Auth::user();
        $comment = Comment::find($id);
        $comment->load('post');
        return view('posts.comment_edit',compact('comment','loginUser'));
    }

    public function update($id, Request $request){
        $comment = Comment::find($id);
        $comment->update([
            'comment'=>$request->content,
        ]);
        return redirect('/posts/'.$request->post_id);
    }

    public function delete($id, Request $request){
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('/posts/'.$request->post_id);
    }
}
