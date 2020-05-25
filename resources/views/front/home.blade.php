@extends('front.layouts.master')
@section('title','Anasayfa')

@section('content')
    <!-- Main Content -->
    <div class="container">
        <div class="row">

            @include('front.widgets.categoryWidget')

            <div class="col-md-9 mx-auto">

                @foreach($articles as $article)
                    <div class="post-preview">
                        <a href="{{route('blog.single',[$article->getCategory->slug,$article->slug])}}">
                            <h2 class="post-title">
                                {{$article->title}}
                            </h2>
                            <img src="{{$article->image}}" width="800" height="400"/>
                            <h3 class="post-subtitle">
                                {{$article->content}}
                            </h3>
                        </a>
                        <p class="post-meta">Kategori:
                            <a href="#">{{$article->getCategory->name}}</a>
                              <span class="float-right">{{$article->created_at->diffForHumans()}}</span></p>
                    </div>
                    @if(!$loop->last)
                        <hr>

                @endif

            @endforeach

                <!-- Pager -->
                {{$articles->links()}}


            </div>
        </div>
    </div>

@endsection
