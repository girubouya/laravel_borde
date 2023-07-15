@extends('layouts.posts.app')
@section('javascript')
    <script src="{{asset('js/posts.js')}}"></script>
@endsection

@include('components.posts.alert')

@section('content')

<a href="{{route('posts.index')}}">戻る</a>
<div class="card mb-3">
    <div class="card-body">
        <h4 class="card-title">{{$post->title}}
            <span class="fs-6" style="color: #000000">by:{{$post->user->name}}</span>
        </h4>
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
        @endif
    </div>
    {{-- 良いね処理(true=押されている/false=押されていない --}}
    @if ($goodCheck)
        @include('components.posts.like',['post_id'=>$post->id,'option'=>'post','count'=>$goodCount])
    @else
        @include('components.posts.unlike',['post_id'=>$post->id,'option'=>'post','count'=>$goodCount])
    @endif
</div>

{{-- コメント表示 --}}
@if (isset($comments))
@foreach ($comments as $comment)
<div class="row">
    <div class="col-10">
        <div class="card mb-3">
            <div class="card-body">
                <p class="card-text fs-5">{{$comment->comment}} <span class="fs-6 text-purple-300">by:{{$comment->user->name}}</span></p>
                @if (isset($loginUser))
                    @if ($loginUser['id'] === $comment->user_id)
                        <div class="d-flex">
                            <a href="{{route('comment.edit',['comment_id'=>$comment->id])}}" class="btn border me-2">編集</a>

                            <form action="{{route('comment.destroy',['comment_id'=>$comment->id])}}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                <button type="submit" class="btn border">削除</button>
                            </form>
                        </div>
                    @endif

                    {{-- 良いね処理 --}}
                    @if ($loginUser->isLikeComment($comment->id))
                        @include('components.posts.like',['post_id'=>$comment->id,'option'=>'comment','count'=>count($comment->likes)])
                    @else
                        @include('components.posts.unlike',['post_id'=>$comment->id,'option'=>'comment','count'=>count($comment->likes)])
                    @endif

                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

<div class="fixed-bottom">
    <div class="container">
        @include('components.posts.error',['title'=>'comment','message'=>'comment'])
        <form action="{{route('comment.store')}}" method="POST">
            @csrf

            <input type="hidden" name="post_id" value="{{$post->id}}">

            <label class="form-label" for="comment">コメント</label>
            <textarea class="form-control" name="comment" id="comment" cols="100" rows="6"></textarea>
            <input class="btn btn-primary mt-3" type="submit" value="送信">
        </form>
    </div>
</div>
@endsection
