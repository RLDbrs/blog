@if(count($articles)>0)
@foreach($articles as $article)
<div class="post-preview">
  <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
    <h2 class="post-title">
      {{$article->title}}
    </h2>
    <img src="{{$article->image}}">
    <h3 class="post-subtitle">
      {!!str_limit($article->content,100)!!}
    </h3>
  </a>
  <p class="post-meta"> katagori:
    <a href="#">{{$article->getCategory->name}}</a>
    <span class="float-right">{{$article->created_at->diffForHumans()}}</span></p>
</div>
<!-- Pager -->
@if(!$loop->last)
<hr>
@endif
@endforeach
{{$articles->links()}}
@else
<div class="alert alert-danger">
  <h1>bu kategoriye ait sayfa bulunamadı</h1>
</div>
@endif
