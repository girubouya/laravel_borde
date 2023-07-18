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
    public function index(Request $request)
    {
        $loginUser = Auth::user();  //ログインしているユーザー
        $paginate = ''; //何を基準でページネーションするかの変数

        //検索キーワードが無ければ全てのデータ取得
        if(empty(session('keyword'))){
            $posts = Post::orderBy('id','desc')->paginate(3); //データを取ってくる
            //名前で検索する
            if(isset($request->name)){
                $posts = Post::where('user_id',$request->name)->paginate(3);
                $paginate = 'name';
            }
        }else{
            $keyword = session('keyword');
            $posts = Post::where('title','LIKE',"%{$keyword}%")->paginate(3);
            //検索キーワードがありかつ、名前で検索したデータ取得
            if(isset($request->name)){
                $posts = Post::where('user_id',$request->name)->where('title','LIKE',"%{$keyword}%")->paginate(3);
                $paginate = 'name';
            }
        }

        return view('posts.index',compact('posts','loginUser','paginate'));    //index.blade.phpを表示
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
            //ログインしているユーザーのID
            $id = Auth::id();
            //入力した値を連想配列に入れる
            $posts = [
                'user_id'=>$id,
                'title'=>$request->title,
                'content'=>$request->content,
            ];

            //Postのインスタンス
            $post = new Post;
            //連想配列のデータをDBに入れる
            $post->fill($posts)->save();
            $message = '送信できました！';

            return redirect()->route('posts.index')->with(compact('message'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //選択されたPostのidでDBに検索をかけデータを取る
        $comments = Comment::where('post_id',$post->id)->get();
        //user情報取得
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
        //user情報取得
        $loginUser = Auth::user();
        return view('posts.edit',compact('post','loginUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //DBに入力されたデータを更新する
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
        //データ削除
        $post->delete();
        $message="削除完了";
        return redirect()->route('posts.index')->with(compact('message'));
    }

    //検索処理
    public function search(Request $request){
        //検索キーワード取得
        $keyword = $request->search;
        // セッションに保存
        session(['keyword'=>$keyword]);
        //ページネーションをsearchにする
        $paginate='search';

        // キーワードに何も入力されていなかったら
        if($keyword === null){
            //セッション削除
            session()->forget('keyword');
            // 全てのデータ取得
            $posts = Post::paginate(3);
            $message = '';
        }else{
            //検索された単語をDBから取得
            $posts = Post::where('title','LIKE',"%{$keyword}%")->paginate(3);
            // もしDBにデータが無かったら０/あれば件数取得
            if(empty($posts)){
                $message = '検索結果は0件です';
            }else{
                $searchCount = Post::where('title','LIKE',"%{$keyword}%")->count();
                $message = "検索結果は{$searchCount}件です";
            }
        }

        $loginUser = Auth::user();
        return view('posts.index',compact('posts','loginUser','message','keyword','paginate'));
    }
}
