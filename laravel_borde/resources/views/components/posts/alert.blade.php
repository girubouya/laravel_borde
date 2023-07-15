{{-- メッセージがあればアラートを表示 --}}
@if (session('message'))
 <p class="alert alert-primary">{{session('message')}}</p>
@endif
