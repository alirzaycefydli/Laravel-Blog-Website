@isset($categories)
<div class="col-md-3 mx-auto">
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{{route('category',$category->slug)}}" class="list-group-item @if(Request::segment(2) == $category->slug) active  @endif">{{$category->name}} <span class="badge bg-dark text-light">
                    {{$category->categoryCount()}}
                </span></a>
        @endforeach
    </div>
</div>
@endisset
