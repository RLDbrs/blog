@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')
<div class="row">

  <div class="col-md-4">
    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                    </div>
                    <div class="card-body">
                      <form method="post" action="{{route('admin.category.create')}}">
                        @csrf
                        <div class="form-group">
                          <label>Kategori adı</label>
                          <input type="text" class="form-control" name="category" required/>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-block">Ekle</button>
                        </div>
                      </form>
                    </div>
                  </div>
</div>
<div class="col-md-8">
  <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Kategori Başlığı</th>
                            <th>Makale Sayısı</th>
                            <th>İşlemler</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($categories as $category)
                          <tr>
                            <td>{{$category->name}}</td>
                            <td>{{$category->articleCount()}}</td>
                            <td>
                              <a category-id="{{$category->id}}" class="btn btn-sm btn-primary edit-click" title="Kategori düzenle"><i class="fa fa-edit text-white"></i></a>
                              <a category-id="{{$category->id}}" category-name="{{$category->name}}" category-count="{{$category->articleCount()}}" class="btn btn-sm btn-danger remove-click" title="Kategori sil"><i class="fa fa-times text-white"></i></a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
    </div>
  </div>
</div>
</div>
<div class="modal" id="editModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">KATEGORİYİ DÜZENLE</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form  action="{{route('admin.category.update')}}" method="post">
          @csrf
          <div class="form-group">
            <label>Kategori Adı</label>
            <input id="category" type="text" class="form-control" name="category"/>
            <input type="hidden" name="id" id="category_id"/>
          </div>
          <div class="form-group">
            <label>Kategori Slug</label>
            <input id="slug" name="slug" class="form-control" type="text"/>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">kapat</button>
            <button type="submit" class="btn btn-success">kaydet</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">KATEGORİYİ SİL</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div id="body" class="modal-body">
        <div class="alert alert-danger" id="articleAlert"></div>
      </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">kapat</button>
            <form  action="{{route('admin.category.delete')}}" method="post">
              @csrf
              <button id="deleteButton" type="submit" class="btn btn-success">sil</button>
              <input type="hidden" name="id" id="deleteId"/>
            </form>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
  $(function() {
    $('.remove-click').click(function(){
      id = $(this)[0].getAttribute('category-id');
      count = $(this)[0].getAttribute('category-count');
      name = $(this)[0].getAttribute('category-name');
      if(id==1){
        $('#articleAlert').html(name+' kategorisi silinemez');
        $('#body').show();
        $('#deleteButton').hide();
        $('#deleteModal').modal();
        return;
      }
      $('#deleteButton').show();
      $('#deleteId').val(id);
      $('#articleAlert').html('');
      if(count>0){
        $('#articleAlert').html(name+' kategorisin de '+count+' makale bulunmakta silmek istermisiniz ?');
        $('#body').show();
      }
      else{
            $('#articleAlert').html('Bu kategoride hiç makale bulunmamaktadır.Silmek istediğinize emin misiniz ?');
          }
      $('#deleteModal').modal();
    });
    $('.edit-click').click(function(){
      id = $(this)[0].getAttribute('category-id');
      $.ajax({
        type:'GET',
        url:'{{route('admin.category.getData')}}',
        data:{id:id},
        success:function(data){
          console.log(data);
          $('#slug').val(data.slug);
          $('#category').val(data.name);
          $('#category_id').val(data.id);
          $('#editModal').modal();
        }
      });
    });
  })
</script>
@endsection
