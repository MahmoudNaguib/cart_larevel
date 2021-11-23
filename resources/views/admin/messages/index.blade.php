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
<div class="section-wrapper">
    @if(can('view-'.$module))
    @if (!$rows->isEmpty())
    <div class="table-responsive">
        <table class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-10p">{{trans('app.ID')}} </th>
                    <th class="wd-25p">{{trans('app.Name')}} </th>
                    <th class="wd-15p">{{trans('app.Email')}} </th>
                    <th class="wd-15p">{{trans('app.Content')}} </th>
                    <th class="wd-15p">{{trans('app.Created at')}}</th>
                    <th class="wd-15p">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                <tr>
                    <td class="center">{{$row->id}}</td>
                    <td class="center">{{$row->name}}</td>
                    <td class="center">{{$row->email}}</td>
                    <td class="center">{!! str_limit($row->content,20) !!}</td>
                    <td class="center">{{$row->created_at}}</td>
                    <td class="center">

                        @if(can('view-'.$module))
                        <a class="btn btn-primary btn-xs" href="{{lang()}}/admin/{{$module}}/view/{{$row->id}}" title="{{trans('app.View')}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endif

                        @if(can('delete-'.$module))
                        <a class="btn btn-danger btn-xs" href="{{lang()}}/admin/{{$module}}/delete/{{$row->id}}" title="{{trans('app.Delete')}}" data-confirm="{{trans('app.Are you sure you want to delete this item')}}?">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        @endif
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
    @endif
</div>
@endsection
