@extends('layouts.admin')
@section('title')
<h6 class="slim-pagetitle">
    {{ @$page_title }}
    @if(can('create-'.$module))
    <a href="{{lang()}}/admin/{{$module}}/create" class="btn btn-success">
        <i class="fa fa-plus"></i> {{trans('app.Create')}}
    </a>
    @endif
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
                    <th class="wd-5p">{{trans('app.ID')}} </th>
                    <th class="wd-25p">{{trans('app.Title')}} </th>
                    <th class="wd-15p">{{trans('app.ISO')}} </th>
                    <th class="wd-15p">{{trans('app.Created at')}}</th>
                    <th class="wd-15p">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                <tr>
                    <td class="center">{{$row->id}}</td>
                    <td class="center">{{$row->title}}</td>
                    <td class="center">{{$row->iso}}</td>
                    <td class="center">{{$row->created_at}}</td>
                    <td class="center">
                        @if(can('edit-'.$module))
                        <a class="btn btn-success btn-xs" href="{{lang()}}/admin/{{$module}}/edit/{{$row->id}}" title="{{trans('app.Edit')}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endif

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
