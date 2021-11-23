@extends('layouts.admin')
@section('title')
    <h6 class="slim-pagetitle">
        {{ @$page_title }}
    </h6>
@endsection
@section('content')
    <div class="section-wrapper">
        @if(request('q'))

            @if(isset($products) && !$products->isEmpty())
                <h4>{{trans('app.Products')}}</h4>
                <ul>
                    @foreach($products as $row)
                        <li><a href="admin/products/view/{{$row->id}}" target="_blank">{{$row->title}}</a></li>
                    @endforeach
                </ul>
            @endif

            @if(isset($posts) && !$posts->isEmpty())
                <h4>{{trans('app.Posts')}}</h4>
                <ul>
                    @foreach($posts as $row)
                        <li><a href="admin/posts/view/{{$row->id}}" target="_blank">{{$row->title}}</a></li>
                    @endforeach
                </ul>
            @endif

            @if(isset($users) && !$users->isEmpty())
                <h4>{{trans('app.Users')}}</h4>
                <ul>
                    @foreach($users as $row)
                        <li><a href="admin/users/view/{{$row->id}}" target="_blank">{{$row->name}}, {{$row->email}}, {{$row->mobile}}</a></li>
                    @endforeach
                </ul>
            @endif


        @endif
    </div>
@endsection
