@extends('back.layouts.master')
@section('title','Sayfalar')
@section('content')
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"
          xmlns:float="http://www.w3.org/1999/xhtml">
@endsection
@section('content')

    <div class="card shadow mb-4">
        <div class="card-body">
            <div id="ordermessage" style="display:none;" class="alert alert-success">
                Sıralama işlemi başarıyla gerçekleşti!
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th>Sıralama</th>
                        <th>Fotoğraf</th>
                        <th>Sayfa Başlığı</th>
                        <th>Sayfa İçeriği</th>
                        <th>Slug</th>
                        <th>aa</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody id="pageSort">
                    @foreach($pages as $page)
                        <tr id="page_{{$page->id}}">
                            <td class="handle" style="cursor: move; text-align: center;"><i class="fa fa-arrow-alt-circle-down fa-2x"></i><i class="fa fa-arrow-alt-circle-up fa-2x"></i></td>
                            <td>
                                <img src="{{ asset($page->image) }}" width="200" height="150">
                            </td>
                            <td>{{ $page->title }}</td>
                            <td>{{$page->content}}</td>
                            <td>{{ $page->slug }}</td>
                            <td>asd</td>
                            <td>
                                <input class="activation" data-id="{{$page->id}}" @if($page->status == 1) checked
                                       @endif type="checkbox" data-on="Aktif" data-off="Pasif" data-offstyle="danger"
                                       data-toggle="toggle" data-onstyle="primary">
                            </td>
                            <td>
                                <a target="_blank" href="{{route('page',$page->slug)}}" title="Görüntüle" class="btn btn-sm btn-success"> <i class="fa fa-eye"></i></a>
                                <a href="{{route('page.edit',$page->id)}}" title="Düzenle"
                                   class="btn btn-sm btn-primary"> <i
                                        class="fa fa-pen"></i></a>
                                <a href="{{route('delete.page',$page->id)}}" title="Sil"
                                   class="btn btn-sm btn-danger"> <i class="fa fa-times"></i></a>
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
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script>
        $('#pageSort').sortable({
            handle:'.handle',
            update:function () {
               var order= $('#pageSort').sortable('serialize');

               $.get("{{route('page.orders')}}?"+order,function (data,status) {
                    $("#ordermessage").show().delay(1000).fadeOut();
               });
            },
        });
    </script>
    <script>
        $(function () {
            $('.activation').change(function () {
                id = $(this)[0].getAttribute('data-id');
                statu = $(this).prop('checked');
                $.get("{{route('switchPage')}}", {id: id, statu: statu}, function (data, status) {
                    console.log(" data geldi");
                })
            })
        })
    </script>
@endsection
@endsection
