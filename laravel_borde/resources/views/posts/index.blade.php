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

    {{-- 新規投稿入力場所 --}}
    <form action="{{route('posts.index')}}" method="POST" style="margin-bottom: 100px">
        @csrf

        <label class="form-label" for="title">タイトル</label>
        <input class="form-control" type="text" id="title" name="title" value="{{old('title')}}">

        <label class="form-label" for="content">内容</label>
        <textarea class="form-control" name="content" id="content" cols="100" rows="10">{{old('content')}}</textarea>

        <input class="btn btn-primary mt-3" type="submit" value="送信">
    </form>

    {{-- 検索数メッセージ --}}
    @if (isset($message))
        {{$message}}
    @endif
    <div class="row align-items-center mb-5">
        <div class="col-3">
            <h2 class="fw-bold text-center">投稿内容</h2>
        </div>
        <div class="col-3">
            {{-- 検索フォーム --}}
            <form action="/posts/search" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="キーワードを入力">
                    <button class="btn btn-outline-success" type="submit" id="searchBtn"><i class="fas fa-search"></i> 検索</button>
                </div>
            </form>
        </div>

        {{-- ページネーション --}}
        @if ($paginate === '')
            <div class="col-3">
                {{$posts->links('pagination::bootstrap-5')}}
            </div>
        @endif
        @if ($paginate === 'name')
            <div class="col-3">
                {{$posts->appends(['name'=>$posts[0]->user_id])->links('pagination::bootstrap-5')}}
            </div>
        @endif
        @if ($paginate === 'search')
            <div class="col-3">
                {{$posts->appends(['search'=>$keyword])->links('pagination::bootstrap-5')}}
            </div>
        @endif

        {{-- 並び替え --}}
        <div class="col-3">
            <form action="{{route('posts.index')}}" method="GET">
                <select name="orderBy">
                    <option value="desc">降順</option>
                    <option value="asc">昇順</option>
                </select>
                <input type="submit" value="並び替え" class="btn btn-primary">
            </form>
        </div>
    </div>

    {{-- 投稿一覧表示 --}}
    @if (isset($posts))
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex">
                        <a href="{{route('posts.show',$post)}}" style="text-decoration: none"><h4 class="card-title">{{$post->title}}</h4></a>
                        <a href="{{route('posts.index',['name'=>$post->user_id])}}">
                            <p class="fs-6 ms-3" style="color: #000000">by:{{$post->user->name}}</p>
                            <?php session('name',$post->user_id); ?>
                        </a>
                    </div>

                    <p class="card-text">{{$post->content}}</p>

                    @if (Auth::check())
                        @if ($loginUser['id'] === $post->user_id)
                            @include('components.posts.editDelete',['routeEdit'=>route('posts.edit',$post),'routeDelete'=>route('posts.destroy',$post),'postId'=>''])
                        @endif
                        {{-- 良いね処理(true=押されている/false=押されていない --}}
                        @if ($loginUser->isLike($post->id))
                            @include('components.posts.like',['post_id'=>$post->id,'option'=>'post','count'=>count($post->likes)])
                        @else
                            @include('components.posts.unlike',['post_id'=>$post->id,'option'=>'post','count'=>count($post->likes)])
                        @endif
                    @endif

                    @guest
                    <div class=" text-end">
                        <i class="fa-solid fa-fish fa-2x good_icon"></i>
                        <span id="goodCount" style="color: #000000">*{{count($post->likes)}}</span>
                    </div>
                    @endguest

                </div>
            </div>
        @endforeach
    @endif
@endsection
