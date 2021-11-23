@extends('layouts.admin')
@section('title')
    <h6 class="slim-pagetitle">
        {{ @$page_title }}
        @if(can('view-'.$module))
            <a href="{{lang()}}/admin/{{$module}}/export?{{@$_SERVER['QUERY_STRING']}}" class="btn btn-primary">
                <i class="fa fa-download"></i> {{trans('app.Export')}}
            </a>
        @endif
    </h6>
@endsection
@section('content')
<div class="col-md-12">

    <div class="section-wrapper col-md-12">
        @if (!$rows->isEmpty())
        <div class="table-wrapper">
            <table class="table display responsive nowrap">
                <thead>
                    <tr>
                        <th class="wd-5p">{{trans('app.ID')}} </th>
                        <th class="wd-10p">{{trans('app.Title')}} </th>
                        <th class="wd-20p">{{trans('app.Content')}} </th>
                        <th class="wd-10p">{{trans('app.URL')}} </th>
                        <th class="wd-10p">{{trans('app.Created at')}}</th>
                        <th class="wd-15p">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                    <tr>
                        <td class="center">{{$row->id}}</td>
                        <td class="center">{{str_limit($row->title,25)}}</td>
                        <td class="center">{{str_limit($row->content,35)}}</td>
                        <td class="center"><a href="{{$row->url}}" target="_blank">{{str_limit($row->url,20)}}</a></td>
                        <td class="center">{{$row->created_at}}</td>
                        <td class="center">
                            <a class="btn btn-primary btn-xs" href="{{lang()}}/{{$module}}/view/{{$row->id}}" title="{{trans('app.View')}}">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-danger btn-xs" href="{{lang()}}/{{$module}}/delete/{{$row->id}}" title="{{trans('app.Delete')}}" data-confirm="{{trans('app.Are you sure you want to delete this item')}}?">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="paganition-center">
            {!! $rows->appends([])->render() !!}
        </div>
        @else
        {{trans("app.There is no results")}}
        @endif
    </div>
</div>

@endsection
