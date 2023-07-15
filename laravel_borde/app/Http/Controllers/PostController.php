<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loginUser = Auth::user();  //ログインしているユーザー

        if(empty(session('keyword'))){
            $posts = Post::orderBy('id','desc')->paginate(4); //データを取ってくる
        }else{
            $keyword = session('keyword');
            $posts = Post::where('title','LIKE',"%{$keyword}%")->get();
        }

        return view('posts.index',compact('posts','loginUser'));    //index.blade.phpを表示
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
        //もしログインしていないユーザーが送信ボタンを押した場合
        if(Auth::user() === null){
            $message = 'ログインすれば掲示板に送信できます!';
            return redirect()->route('posts.index')->with(compact('message'));
        }else{
            $id = Auth::id();   //ログインしているユーザーのID
            //入力した値を連想配列に入れる
            $posts = [
                'user_id'=>$id,
                'title'=>$request->title,
                'content'=>$request->content,
            ];

            $post = new Post;   //Postのインスタンス
            $post->fill($posts)->save();    //連想配列のデータをDBに入れる
            $message = '送信できました！';

            return redirect()->route('posts.index')->with(compact('message'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments = Comment::where('post_id',$post->id)->get(); //選択されたPostのidでDBに検索をかけデータを取る
        $loginUser = Auth::user();

        //ログインユーザーが選択されている投稿に良いねしたか調べる
        $goodCheck = $loginUser->isLike($post->id);
        //良いねしている総数を取得
        $goodCount = Like::where('post_id',$post->id)->count();

        return view('posts.show',compact('post','loginUser','comments','goodCheck','goodCount'));
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

    public function search(Request $request){
        $keyword = $request->search;
        session(['keyword'=>$keyword]);

        if($keyword === null){
            //何も検索されていなかったらすべて取得
            $posts = Post::all();
            $message = '';
        }else{
            //検索された単語をDBから取得
            $posts = Post::where('title','LIKE',"%{$keyword}%")->get();
            if(empty($posts)){
                $message = '検索結果は0件です';
            }else{
                $searchCount = count($posts);
                $message = "検索結果は{$searchCount}件です";
            }
        }

        $loginUser = Auth::user();
        return view('posts.index',compact('posts','loginUser','message'));
    }
}
