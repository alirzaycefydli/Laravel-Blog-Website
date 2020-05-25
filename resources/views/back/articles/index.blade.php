@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"
          xmlns:float="http://www.w3.org/1999/xhtml">
@endsection
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">

            <h6 class="m-0  font-weight-bold text-primary float-right"><strong>{{$articles->count()}}</strong> makale
                bulundu.
                <a href="{{route('deleted.article')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i> Silinen
                    Makaleler</a></h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Görüntülenme Sayısı</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>
                                <img src="{{ asset($article->image) }}" width="200" height="150">
                            </td>
                            <td>{{ $article->title }}</td>
                            <td>{{$article->getCategory->name}}</td>
                            <td>{{ $article->hit }}</td>
                            <td>{{ $article->created_at->diffForHumans() }}</td>
                            <td>
                                <input class="activation" data-id="{{$article->id}}" @if($article->status == 1) checked
                                       @endif type="checkbox" data-on="Aktif" data-off="Pasif" data-offstyle="danger"
                                       data-toggle="toggle" data-onstyle="primary">
                            </td>
                            <td>
                                <a target="_blank" href="{{route('blog.single',[$article->getCategory->slug,$article->slug])}}" title="Görüntüle" class="btn btn-sm btn-success"> <i class="fa fa-eye"></i></a>
                                <a href="{{route('makaleler.edit',$article->id)}}" title="Düzenle"
                                   class="btn btn-sm btn-primary"> <i
                                        class="fa fa-pen"></i></a>
                                <a href="{{route('delete.article',$article->id)}}" title="Sil"
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
    <script>
        $(function () {
            $('.activation').change(function () {
                id = $(this)[0].getAttribute('data-id');
                statu = $(this).prop('checked');
                $.get("{{route('switchStatus')}}", {id: id, statu: statu}, function (data, status) {

                })
            })
        })
    </script>
@endsection
