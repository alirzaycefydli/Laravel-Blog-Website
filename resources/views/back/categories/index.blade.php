@extends('back.layouts.master')
@section('title','Kategoriler')
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"
          xmlns:float="http://www.w3.org/1999/xhtml">
@endsection
@section('content')





    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('category.create')}}">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                            <tr>
                                <th>Kategori Adı</th>
                                <th>Makale Sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>4</td>
                                    <td>
                                        <input class="activation" data-id="{{$category->id}}"
                                               @if($category->status == 1) checked
                                               @endif type="checkbox" data-on="Aktif" data-off="Pasif"
                                               data-offstyle="danger"
                                               data-toggle="toggle" data-onstyle="primary">
                                    </td>
                                    <td>
                                        <a data-id="{{$category->id}}" class="btn btn-sm btn-primary edit-click"
                                           title="Kategoriyi Düzenle"><i class="fa fa-edit text-white"></i></a>
                                        <a data-id="{{$category->id}}" category-name="{{$category->name}}" title="Kategoriyi Sil" class="btn btn-sm btn-danger delete-click">
                                            <i class="fa fa-trash text-white"></i></a>
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


    <!-- Update Modal -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi Düzenle</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{route('category.update')}}">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input id="category" type="text" class="form-control" name="category">
                            <input id="category_id" type="hidden" name="id">
                        </div>
                        <div class="form-group">
                            <label>Kategori Slug</label>
                            <input id="slug" type="text" class="form-control" name="slug">

                        </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi Sil</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="message" class="alert-danger">Bu kategoriyi silmek istediğinize emin misiniz?</div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                    <form method="post" action="{{route('category.delete')}}">
                        @csrf
                        <input type="hidden" name="id" id="categoryId">
                        <button id="deleteButton" type="submit" class="btn btn-danger">Sil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function () {

            $('.delete-click').click(function () {
                id = $(this)[0].getAttribute('data-id');
                categoryName = $(this)[0].getAttribute('category-name');
                $('#deleteModal').modal();
                $('#categoryId').val(id);
                $('#message').html('Bu kategoriyi silmek istediğinize emin misiniz?')
                $('#deleteButton').show();
                if(id==6){
                    $('#deleteButton').hide();
                    $('#message').html(categoryName+' adlı kategori silinemez.')
                }

            });

            $('.edit-click').click(function () {
                id = $(this)[0].getAttribute('data-id');
                $.ajax({
                    type: 'GET',
                    url: '{{route('category.getdata')}}',
                    data: {id: id},
                    success(data) {
                        console.log(data);
                        $('#category').val(data.name);
                        $('#slug').val(data.slug);
                        $('#category_id').val(data.id);
                        $('#editModal').modal();
                    }
                });
            });



            $('.activation').change(function () {
                id = $(this)[0].getAttribute('data-id');
                statu = $(this).prop('checked');
                $.get("{{route('category.switch')}}", {id: id, statu: statu}, function (data, status) {

                })
            })
        })
    </script>
@endsection
