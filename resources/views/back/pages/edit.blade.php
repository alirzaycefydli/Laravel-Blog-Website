@extends('back.layouts.master')
@section('title',$page->title.' makalesini güncelle')
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
            <form method="post" action="{{route('page.update',$page->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Sayfa Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{$page->title}}" required> </input>
                </div>
                <div class="form-group">
                    <label>Sayfa Fotoğrafı</label> <br>
                    <img class="rounded img-thumbnail" src="{{asset($page->image)}}" width="300">
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-group">
                    <label>Sayfa İçeriği</label>
                    <textarea id="editor"rows="5" name="content" class="form-control" required>{!! $page->content !!} </textarea>
                </div>

                <div class="form-group">
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
