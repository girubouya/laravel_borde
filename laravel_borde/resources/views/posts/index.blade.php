@extends('layouts.posts.app')
@section('javascript')
    <script src="{{asset('js/posts.js')}}"></script>
@endsection


@section('content')

    {{-- エラー表示 --}}
    @include('components.posts.error',['title'=>'title','message'=>'title'])
    @include('components.posts.error',['title'=>'content','message'=>'content'])
    {{-- 送信が出来たらメッセージ表示    --}}
    @include('components.posts.alert')

    {{-- 入力場所 --}}
    <form action="{{route('posts.index')}}" method="POST" style="margin-bottom: 100px">
        @csrf

        <label class="form-label" for="title">タイトル</label>
        <input class="form-control" type="text" id="title" name="title" value="{{old('title')}}">

        <label class="form-label" for="content">内容</label>
        <textarea class="form-control" name="content" id="content" cols="100" rows="10">{{old('content')}}</textarea>

        <input class="btn btn-primary mt-3" type="submit" value="送信">
    </form>

    {{-- 検索場所 --}}
    @if (isset($message))
        {{$message}}
    @endif
    <div class="row align-items-center mb-5">
        <div class="col-9">
            <h2 class="fw-bold text-center">投稿内容</h2>
        </div>
        <div class="col-3">
            <form action="{{route('posts.search')}}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="キーワードを入力">
                    <button class="btn btn-outline-success" type="submit" id="searchBtn"><i class="fas fa-search"></i> 検索</button>
                </div>
            </form>
        </div>
    </div>
    {{-- 一覧表示 --}}
    @if (isset($posts))
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{route('posts.show',$post)}}" style="text-decoration: none">
                        <h4 class="card-title">{{$post->title}}
                            <span class="fs-6" style="color: #000000">by:{{$post->user->name}}</span>
                        </h4>
                    </a>
                    <p class="card-text">{{$post->content}}</p>

                    @if (isset($loginUser))
                        @if ($loginUser['id'] === $post->user_id)
                            @include('components.posts.editDelete',['routeEdit'=>route('posts.edit',$post),'routeDelete'=>route('posts.destroy',$post)])
                        @endif
                        {{-- 良いね処理(true=押されている/false=押されていない --}}
                        @if ($loginUser->isLike($post->id))
                            @include('components.posts.like',['post_id'=>$post->id,'option'=>'post','count'=>count($post->likes)])
                        @else
                            @include('components.posts.unlike',['post_id'=>$post->id,'option'=>'post','count'=>count($post->likes)])
                        @endif
                    @endif

                </div>
            </div>
        @endforeach
    @endif
@endsection
