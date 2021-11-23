@extends('layouts.admin')
@section('title')
<h6 class="slim-pagetitle">
    {{ @$page_title }}
</h6>
@endsection
@section('content')
<div class="section-wrapper">
    @if(can('edit-'.$module))
    <a href="{{lang()}}/admin/{{$module}}/edit/{{$row->id}}" class="btn btn-success">
        <i class="fa fa-edit"></i> {{trans('app.Edit')}}
    </a><br>
    @endif
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
            <tr>
                <td width="25%" class="align-left">{{trans('app.Role')}}</td>
                <td width="75%" class="align-left">{{@$row->role->title}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Country')}}</td>
                <td width="75%" class="align-left">{{@$row->country->title}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Name')}}</td>
                <td width="75%" class="align-left">{{@$row->name}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Email')}}</td>
                <td width="75%" class="align-left">{{@$row->email}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Mobile')}}</td>
                <td width="75%" class="align-left">{{@$row->mobile}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Language')}}</td>
                <td width="75%" class="align-left">{{@$row->language}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Avatar')}}</td>
                <td width="75%" class="align-left">{!! image($row->image,'small') !!}</td>
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
