<h1>
    @if(isset($title)){{$title}}@endif
</h1>

<ol class="breadcrumb">

    <li><a href="{{route('blog.admin.index.index')}}"><i class="fa fa-dashboard"></i>{{$parent}}</a></li>
    @if(isset($order))
        <li><a href=""><i></i>{{$order}}</a></li>

    @endif
    @if(isset($categoty))
        <li><a href=""><i></i>{{$category}}</a></li>
    @endif
    @if(isset($user))
        <li><a href=""><i></i>{{$user}}</a></li>
    @endif
    @if(isset($product))
        <li><a href=""><i></i>{{$product}}</a></li>
    @endif
    @if(isset($group_filter))
        <li><a href=""><i></i>{{$group_filter}}</a></li>
    @endif
    @if(isset($attr_filter))
        <li><a href=""><i></i>{{$attr_filter}}</a></li>
    @endif
    @if(isset($currency))
        <li><a href=""><i></i>{{$currency}}</a></li>
    @endif
    @if(isset($active))
    <li><i class="active"></i>{{$active}}</li>
    @endif
</ol>
