<div class="d-flex">
    <a href="{{$routeEdit}}" class="btn border me-2">編集</a>

    <form action="{{$routeDelete}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn border">削除</button>
    </form>
</div>
