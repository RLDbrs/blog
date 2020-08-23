@extends('front.layouts.master')
@section('title',$category->name.' Sayfası | ' .count($articles).' sayfa kaynağı görüntüleniyor')
@section('content')
  <!-- Main Content -->
      <div class="col-md-8 mx-auto">
        @include('front.widgets.articlelist')
        </div>
      @include('front.widgets.CategoryWidgets')
@endsection
