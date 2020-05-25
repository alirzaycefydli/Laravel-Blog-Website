@extends('back.layouts.master')
@section('title','Yeni Makale')
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
            <form method="post" action="{{route('makaleler.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Makale Başlığı</label>
                    <input type="text" name="title" class="form-control" required> </input>
                </div>

                <div class="form-group">
                    <label>Makale Kategorisi</label>
                    <select class="form-control" name="category_id" required>
                    <option value="">Seçim Yapınız</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Makale Fotoğrafı</label>
                    <input type="file" name="image" class="form-control" required> </input>
                </div>

                <div class="form-group">
                    <label>Makale İçeriği</label>
                    <textarea id="editor"rows="5" name="content" class="form-control" required> </textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"> Kaydet</button>
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
