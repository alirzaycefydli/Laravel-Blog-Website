@extends('back.layouts.master')
@section('title',$article->title.' makalesini güncelle')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('content')

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($errors->any())
                <div class="alert aler-danger">
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif
            <form method="post" action="{{route('makaleler.update',$article->id)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>Makale Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{$article->title}}" required> </input>
                </div>

                <div class="form-group">
                    <label>Makale Kategorisi</label>
                    <select class="form-control" name="category_id" required>
                    <option value="">Seçim Yapınız</option>
                        @foreach($categories as $category)
                            <option @if($article->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Makale Fotoğrafı</label> <br>
                    <img class="rounded img-thumbnail" src="{{asset($article->image)}}" width="300">
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group">
                    <label>Makale İçeriği</label>
                    <textarea id="editor"rows="5" name="content" class="form-control" required>{!! $article->content !!} </textarea>
                </div>

                <div class="form-group">
                    <label>Makale Başlığı</label>
                    <button type="submit" class="btn btn-primary btn-block"> Güncelle </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#editor').summernote(
                {'height':300}
            );
        });
    </script>
@endsection
