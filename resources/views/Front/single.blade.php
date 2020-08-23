@extends('front.layouts.master')
@section('title',$article->title)
@section('bg',$article->image)
@section('content')
  <!-- Main Content -->
        <div class="col-md-9 mx-auto">
          {!!$article->content!!}
          <br/>
      <span class="text-danger">okuma sayısı : <b>{{$article->hit}}</b></span>
        </div>
      @include('front.widgets.CategoryWidgets')
@endsection
