@extends('front.layouts.master')
@section('title','İletişim' )
@section('bg','https://www.troax.com/sites/default/files/styles/header_image_desktop_/public/2019-08/Contact_header_2880x1000px.jpg?itok=9hgrfHuH')
@section('content')
    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
                @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                           <ul>
                               @foreach($errors->all() as $error)
                                   <li>{{$error}}</li>
                               @endforeach
                           </ul>
                        </div>
                    @endif
                <p>Bizimle iletişime geçin.</p>

                <form method="post" action="{{route('contact.post')}}">
                    @csrf
                    <div class="control-group">
                        <div class="form-group  controls">
                            <label>Ad-Soyad</label>
                            <input type="text" class="form-control" value="{{old('name')}}" placeholder="Adınız-Soyadınız" name="name" required>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group  controls">
                            <label>Email Adresi</label>
                            <input type="email" class="form-control" value="{{old('email')}}" placeholder="Email Adresiniz" name="email"
                                   required>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group col-xs-12  controls">
                            <label>Konu</label>
                            <select class="form-control" name="topic">
                                <option @if(old('topic') == 'Bilgi') selected @endif >Bilgi</option>
                                <option @if(old('topic') == 'Destek') selected @endif>Destek</option>
                                <option @if(old('topic') == 'Genel') selected @endif>Genel</option>
                            </select>

                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group  controls">
                            <label>Mesajınız</label>
                            <textarea rows="5" type="text" value="{{old('message')}}" class="form-control" placeholder="Mesajınız" name="message" required> </textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="sendMessageButton">Gönder</button>
                    </div>
                </form>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>İletişim Bilgilerimiz</h3>
                        <div class="card-body text-info">
                            <h6><span class="text-dark"> Adres:</span> Deneme Mahallesi, Deneme Blok, No:Deneme</h6>
                            <h6><span class="text-dark"> Mail:</span> deneme@deneme.com</h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection



