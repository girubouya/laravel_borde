@extends('layouts.posts.app')

@section('content')
    <h2 class="text-center fw-bold">編集</h2>
    <form action="{{route('comment.update',$comment->id)}}" method="POST">
        @csrf

        <label class="form-label" for="content">内容</label>
        <textarea class="form-control" name="content" id="content" cols="100" rows="10">{{$comment->comment}}</textarea>

        <input type="hidden" name="post_id" value="{{$comment->post->id}}">
        <input class="btn btn-primary mt-3" type="submit" value="送信">
    </form>


@endsection
