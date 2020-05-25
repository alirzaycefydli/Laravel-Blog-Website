@extends('back.layouts.master')
@section('title','Ayarlar')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{route('settings.update')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Başlığı</label>
                            <input type="text" name="title" value="{{$settings->title}}" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Aktiflik Durumu</label>
                            <select class="form-control" name="active">
                                <option @if($settings->status == 1) selected @endif value="1">Açık</option>
                                <option @if($settings->status == 0) selected @endif value="0">Kapalı</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Logosu</label>
                            <input type="file" name="logo" class="form-control">
                            @if($settings->logo != null)
                            <img src="{{asset($settings->logo)}}" width="200" height="150">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Fav İconu</label>
                            <input type="file" name="favicon" class="form-control">
                            @if($settings->favicon != null)
                                <img src="{{asset($settings->favicon)}}" width="200" height="150">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="text" name="facebook" value="{{$settings->facebook}}" required
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Linked In</label>
                            <input type="text" name="linkedin" value="{{$settings->linkedin}}" required
                                   class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Github</label>
                            <input type="text" name="github" value="{{$settings->github}}" required
                                   class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
@endsection
