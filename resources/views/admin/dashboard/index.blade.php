@extends('layouts.admin')
@section('title')
    <h6 class="slim-pagetitle"> {{ trans('app.Welcome') .', '.auth()->user()->name }}</h6>
@endsection

@section('content')
    <div class="row row-xs">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-status">
                <div class="media">
                    <i class="icon ion-ios-pricetag"></i>
                    <div class="media-body">
                        <h1>{{@$total_products}}</h1>
                        <p>{{ trans('app.Total')}} {{trans('app.Products')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-status">
                <div class="media">
                    <i class="icon ion-ios-cart"></i>
                    <div class="media-body">
                        <h1>{{@$total_orders}}</h1>
                        <p>{{ trans('app.Total')}} {{trans('app.Orders')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-status">
                <div class="media">
                    <i class="icon ion-ios-list"></i>
                    <div class="media-body">
                        <h1>{{@$total_posts}}</h1>
                        <p>{{ trans('app.Total')}} {{trans('app.Posts')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-status">
                <div class="media">
                    <i class="icon ion-ios-contact"></i>
                    <div class="media-body">
                        <h1>{{@$total_users}}</h1>
                        <p>{{ trans('app.Total')}} {{trans('app.Users')}}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row row-xs">
        @if( can('view-products'))
            <div class="col-md-6 mg-t-15">
                <div class="card card-table">
                    <div class="card-header">
                        <h6 class="slim-card-title">{{ trans('app.Latest')}} {{trans('app.Products')}}</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                            <tr class="tx-10">
                                <th class="wd-10p">{{ trans('app.Category')}}</th>
                                <th class="wd-5p">{{ trans('app.Image')}}</th>
                                <th class="wd-10p">{{ trans('app.Title')}}</th>
                                <th class="wd-5p">{{ trans('app.Price')}}</th>
                                <th class="wd-5p">{{ trans('app.Views')}}</th>
                                <th class="wd-10p">{{ trans('app.Created at')}}</th>
                                <th class="wd-10p"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$products->isEmpty())
                                @foreach($products as $row)
                                    <tr>
                                        <td class="center">{{$row->category->title}}</td>
                                        <td class="center">{!! image($row->image,'small',['width'=>50]) !!}</td>
                                        <td class="center">{{$row->title_limited}}</td>
                                        <td class="center">{{$row->final_price}}</td>
                                        <td class="center">{{$row->views}}</td>
                                        <td class="center">{{str_limit($row->created_at,10,false)}}</td>
                                        <td class="center">
                                            <a class="btn btn-primary btn-xs" href="{{lang()}}/admin/products/view/{{$row->id}}" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer tx-12 bg-transparent">
                        <a href="{{lang()}}/products"><i class="fa fa-angle-down mg-r-5"></i>{{trans('app.View all')}}</a>
                    </div>
                </div>
            </div>
        @endif
        @if( can('view-posts'))
            <div class="col-md-6 mg-t-15">
                <div class="card card-table">
                    <div class="card-header">
                        <h6 class="slim-card-title">{{ trans('app.Latest')}} {{trans('app.Posts')}}</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                            <tr class="tx-10">
                                <th class="wd-10p">{{ trans('app.Section')}}</th>
                                <th class="wd-5p">{{ trans('app.Image')}}</th>
                                <th class="wd-10p">{{ trans('app.Title')}}</th>
                                <th class="wd-5p">{{ trans('app.Views')}}</th>
                                <th class="wd-10p">{{ trans('app.Created at')}}</th>
                                <th class="wd-10p"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$posts->isEmpty())
                                @foreach($posts as $row)
                                    <tr>
                                        <td class="center">{{$row->section->title}}</td>
                                        <td class="center">{!! image($row->image,'small',['width'=>50]) !!}</td>
                                        <td class="center">{{$row->title_limited}}</td>
                                        <td class="center">{{$row->views}}</td>
                                        <td class="center">{{str_limit($row->created_at,10,false)}}</td>
                                        <td class="center">
                                            <a class="btn btn-primary btn-xs" href="{{lang()}}/admin/posts/view/{{$row->id}}" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer tx-12 bg-transparent">
                        <a href="{{lang()}}/posts"><i class="fa fa-angle-down mg-r-5"></i>{{trans('app.View all')}}</a>
                    </div>
                </div>
            </div>
        @endif
        @if( can('view-users'))
            <div class="col-md-6 mg-t-15">
                <div class="card card-table">
                    <div class="card-header">
                        <h6 class="slim-card-title">{{ trans('app.Latest')}} {{trans('app.Users')}}</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                            <tr class="tx-10">
                                <th class="wd-10p">{{ trans('app.Name')}}</th>
                                <th class="wd-5p">{{ trans('app.Email')}}</th>
                                <th class="wd-10p">{{ trans('app.Mobile')}}</th>
                                <th class="wd-10p">{{ trans('app.Created at')}}</th>
                                <th class="wd-10p"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$users->isEmpty())
                                @foreach($users as $row)
                                    <tr>
                                        <td class="center">{{$row->name}}</td>
                                        <td class="center">{{$row->email}}</td>
                                        <td class="center">{{$row->mobile}}</td>
                                        <td class="center">{{str_limit($row->created_at,10,false)}}</td>
                                        <td class="center">
                                            <a class="btn btn-primary btn-xs" href="{{lang()}}/admin/users/view/{{$row->id}}" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer tx-12 bg-transparent">
                        <a href="{{lang()}}/users"><i class="fa fa-angle-down mg-r-5"></i>{{trans('app.View all')}}</a>
                    </div>
                </div>
            </div>
        @endif
        @if( can('view-messages'))
            <div class="col-md-6 mg-t-15">
                <div class="card card-table">
                    <div class="card-header">
                        <h6 class="slim-card-title">{{ trans('app.Latest')}} {{trans('app.Messages')}}</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table mg-b-0 tx-13">
                            <thead>
                            <tr class="tx-10">
                                <th class="wd-25p">{{trans('app.Name')}} </th>
                                <th class="wd-15p">{{trans('app.Email')}} </th>
                                <th class="wd-15p">{{trans('app.Content')}} </th>
                                <th class="wd-10p">{{ trans('app.Created at')}}</th>
                                <th class="wd-10p"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$users->isEmpty())
                                @foreach($users as $row)
                                    <tr>
                                        <td class="center">{{$row->name}}</td>
                                        <td class="center">{{$row->email}}</td>
                                        <td class="center">{!! str_limit($row->content,20) !!}</td>
                                        <td class="center">{{str_limit($row->created_at,10,false)}}</td>
                                        <td class="center">
                                            <a class="btn btn-primary btn-xs" href="{{lang()}}/admin/messages/view/{{$row->id}}" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer tx-12 bg-transparent">
                        <a href="{{lang()}}/users"><i class="fa fa-angle-down mg-r-5"></i>{{trans('app.View all')}}</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
