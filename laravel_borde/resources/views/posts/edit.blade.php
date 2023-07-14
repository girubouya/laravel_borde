@extends('layouts.posts.app')

@section('content')
    <h2 class="text-center fw-bold">編集</h2>
    <form action="{{route('posts.update',$post)}}" method="POST">
        @csrf
        @method('PUT')

        <label class="form-label" for="title">タイトル</label>
        <input class="form-control" type="text" id="title" name="title" value="{{$post->title}}">

        <label class="form-label" for="content">内容</label>
        <textarea class="form-control" name="content" id="content" cols="100" rows="10">{{$post->content}}</textarea>

        <input class="btn btn-primary mt-3" type="submit" value="送信">
    </form>
   
@endsection
