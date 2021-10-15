<h2>{{$title}}</h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($parents as $route => $parent)
            @if(!empty($parent))
                <li class="breadcrumb-item"><a href="{{$route}}">{{$parent}}</a></li>
            @endif
        @endforeach
        <li class="breadcrumb-item active">{{$active}}</li>
    </ol>
</nav>
