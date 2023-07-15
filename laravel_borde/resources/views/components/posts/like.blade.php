{{-- いいねの表示 --}}
{{-- $post_id = 投稿IDかコメントID --}}
{{-- $option = 投稿(post)かコメント(comment) --}}
<a href="" class="goodBtn d-block text-end check" data-id="{{$post_id}}" data-option="{{$option}}" style="color: #ff0000; text-decoration:none">
    <i class="fa-solid fa-fish fa-2x good_icon"></i>
    <span id="goodCount" style="color: #000000">*{{$count}}</span>
</a>
