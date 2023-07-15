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
    <form action="/posts" method="POST">
        @csrf

        <label class="form-label" for="title">タイトル</label>
        <input class="form-control" type="text" id="title" name="title" value="{{old('title')}}">

        <label class="form-label" for="content">内容</label>
        <textarea class="form-control" name="content" id="content" cols="100" rows="10">{{old('content')}}</textarea>

        <input class="btn btn-primary mt-3" type="submit" value="送信">
    </form>

    {{-- 一覧表示 --}}
    <h2 class="mt-5 fw-bold text-center">投稿内容</h2>
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
