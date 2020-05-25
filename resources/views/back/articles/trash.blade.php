@extends('back.layouts.master')
@section('title','Silinen Makaleler')

@section('content')

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Görüntülenme Sayısı</th>
                        <th>Silinme Tarihi</th>
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
                            <td>{{$article->hit}}</td>
                            <td>{{ $article->deleted_at->diffForHumans() }}</td>

                            <td>
                                <a href="{{route('recover.article',$article->id)}}" title="Geri Yükle"
                                   class="btn btn-sm btn-primary"> <i class="fa fa-recycle"></i></a>
                                <a href="{{route('delete.article.completely',$article->id)}}" title="Tamamen Sil"
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

