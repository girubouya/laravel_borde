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
                    <a href="{{route('posts.show',$post)}}"><h4 class="card-title">{{$post->title}}</h4></a>
                    <p class="card-text">{{$post->content}}</p>

                    @if (isset($loginUser))
                        @if ($loginUser['id'] === $post->user_id)
                            <div class="d-flex">
                                <a href="{{route('posts.edit',$post)}}" class="btn border me-2">編集</a>

                                <form action="{{route('posts.destroy',$post)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn border">削除</button>
                                </form>
                            </div>
                        @endif
                        {{-- 良いね処理(true=押されている/false=押されていない --}}
                        @if ($loginUser->isLike($post->id))
                            <a href="" class="goodBtn" data-post_id="{{$post->id}}" class="check" style="color: #ff0000; text-decoration:none">
                                <i data-id={{$post->id}} class="fa-solid fa-fish fa-2x good_icon"></i>
                                <span id="goodCount" style="color: #000000">*{{count($post->likes)}}</span>
                            </a>
                        @else
                            <a href="" class="goodBtn" data-post_id="{{$post->id}}" style="color: #000000; text-decoration:none">
                                <i data-id={{$post->id}} class="fa-solid fa-fish fa-2x good_icon"></i>
                                <span id="goodCount" style="color: #000000">*{{count($post->likes)}}</span>
                            </a>
                        @endif
                    @endif

                </div>
            </div>
        @endforeach
    @endif
@endsection
