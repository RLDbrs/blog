@extends('back.layouts.master')
@section('title','Tüm sayfalar')
@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">@yield('title')
    <span class="float-right">{{$pages->count()}} Makale Bulundu </strong>
     </h6>
  </div>
  <div class="card-body">
    <div id="orderSuccess" style="display:none" class="alert alert-success">
      BAŞARI İLE SIRALAMA VERİSİ GÜNCELLENDİ
    </div>
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Sıralamalar</th>
            <th>fotograf</th>
            <th>Sayfa Başlığı</th>
            <th>İşlemler</th>
          </tr>
        </thead>
        <tbody id="orders">
          @foreach($pages as $page)
          <tr id="page_{{$page->id}}">
            <td class="text-center"><i class="fas fa-arrows-alt fa-2x handle" style="cursor:move"></i></td>
            <td>
              <img src="{{asset($page->image)}}" width="100">
            </td>
            <td>{{$page->title}}</td>
            <td>
              <a target="_blank" href="{{route('page',$page->slug)}}" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
              <a href="{{route('admin.page.edit',$page->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
              <a href="{{route('admin.page.delete',$page->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
$('#orders').sortable({
  handle:'.handle',
  update:function(){
  var siralama = $('#orders').sortable('serialize');
  $.get("{{route('admin.page.orders')}}?"+siralama,function(){
    $("#orderSuccess").show().delay(1000).fadeOut();
  });
  }
});
</script>
@endsection
