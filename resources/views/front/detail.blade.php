@extends('front.layouts.master')
@section('title', $articles->title)
@section('bg',asset($articles->image))
@section('content')
    <!-- Main Content -->
    @include('front.widgets.categoryWidget')

                <div class="col-md-9 mx-auto">
                   {{ $articles->content }}

                    <br><br>
                    <span>Okunma Sayısı: {{$articles->hit}}</span>
                </div>
@endsection
