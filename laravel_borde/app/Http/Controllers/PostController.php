<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
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
        return view('posts.index',compact('posts'));
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
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit',compact('post'));
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
