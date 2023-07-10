<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        $loginUser = Auth::user();
        return view('posts.index',compact('posts','loginUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $id = Auth::id();

        $posts = [
            'user_id'=>$id,
            'title'=>$request->title,
            'content'=>$request->content,
        ];

        $post = new Post;
        $post->fill($posts)->save();
        $message = '送信できました！';

        return redirect('/posts')->with(compact('message'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments = Comment::where('post_id',$post->id)->get();
        $comments->load('user');
        $loginUser = Auth::user();
        return view('posts.show',compact('post','loginUser','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $loginUser = Auth::user();
        return view('posts.edit',compact('post','loginUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->update([
            'title'=>$request->title,
            'content'=>$request->content
        ]);
        $message="編集完了";
        return redirect()->route('posts.index')->with(compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        $message="削除完了";
        return redirect()->route('posts.index')->with(compact('message'));
    }
}
