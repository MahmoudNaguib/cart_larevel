@extends('layouts.admin')
@section('title')
<h2 class="register-title">{{$page_title}}</h2>
@endsection
@section('content')
<div class="section-wrapper col-md-12">
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
            <tr>
                <td width="25%" class="align-left">{{trans('app.Title')}}</td>
                <td width="75%" class="align-left">{{@$row->title}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Content')}}</td>
                <td width="75%" class="align-left">{{@$row->content}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Url')}}</td>
                <td width="75%" class="align-left"><a href="{{$row->url}}" target="_blank">{{str_limit($row->url,20)}}</a></td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Created at')}}</td>
                <td width="75%" class="align-left">{{@$row->created_at}}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
