@extends('layouts.posts.app')
@section('content')
<div class="card mb-3">
    <div class="card-body">
        <a href="{{route('posts.show',$post)}}"><h4 class="card-title">{{$post->title}}</h4></a>
        <p class="card-text">{{$post->content}}</p>

        <div class="d-flex">
            <a href="{{route('posts.edit',$post)}}" class="btn border me-2">編集</a>

            <form action="{{route('posts.destroy',$post)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn border">削除</button>
            </form>
        </div>
    </div>
</div>

{{-- コメント表示 --}}
<div>

</div>

<div class="fixed-bottom">
    <div class="container">
        <form action="/posts/{{$post->id}}" method="POST">
            @csrf
            <label class="form-label" for="comment">コメント</label>
            <textarea class="form-control" name="comment" id="comment" cols="100" rows="6"></textarea>
            <input class="btn btn-primary mt-3" type="submit" value="送信">
        </form>
    </div>
</div>
@endsection
