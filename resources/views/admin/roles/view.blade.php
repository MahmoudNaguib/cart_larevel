@extends('layouts.admin')
@section('title')
<h6 class="slim-pagetitle">
    {{ @$page_title }}
</h6>
@endsection
@section('content')
<div class="section-wrapper">
    @if(can('edit-'.$module) && !$row->is_default)
    <a href="{{lang()}}/admin/{{$module}}/edit/{{$row->id}}" class="btn btn-success">
        <i class="fa fa-edit"></i> {{trans('app.Edit')}}
    </a><br>
    @endif
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
            <tr>
                <td width="25%" class="align-left">{{trans('app.Title')}}</td>
                <td width="75%" class="align-left">{{@$row->title}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Permissions')}}</td>
                <td width="75%" class="align-left">
                    {{implode(', ',($row->permissions)?:[])}}
                </td>
            </tr>
            @if(@$row->creator->name)
            <tr>
                <td width="25%" class="align-left">{{trans('app.Created by')}}</td>
                <td width="75%" class="align-left">{{@$row->creator->name}}</td>
            </tr>
            @endif
        </table>
    </div>
</div>
@endsection
