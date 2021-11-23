@extends('layouts.admin')
@section('title')
<h6 class="slim-pagetitle">
    {{ @$page_title }}
</h6>
@endsection
@section('content')
<div class="section-wrapper">
    @if(can('edit-'.$module) )
    <a href="{{lang()}}/admin/{{$module}}/edit/{{$row->id}}" class="btn btn-success">
        <i class="fa fa-edit"></i> {{trans('app.Edit')}}
    </a><br>
    @endif
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
            @foreach(langs() as $lang)
            <tr>
                <td width="25%" class="align-left">{{trans('app.Title')}} {{$lang}}</td>
                <td width="75%" class="align-left">{{@$row->getTranslation('title',$lang)}}</td>
            </tr>
            @endforeach

            @foreach(langs() as $lang)
            <tr>
                <td width="25%" class="align-left">{{trans('app.Content')}} {{$lang}}</td>
                <td width="75%" class="align-left">{!! @$row->getTranslation('content',$lang) !!}</td>
            </tr>
            @endforeach
            <tr>
                <td width="25%" class="align-left">{{trans('app.URL')}}</td>
                <td width="75%" class="align-left">{{@$row->url}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Image')}}</td>
                <td width="75%" class="align-left">{!! image($row->image,'small') !!}</td>
            </tr>

            <tr>
                <td width="25%" class="align-left">{{trans('app.Is active')}}</td>
                <td width="75%" class="align-left"><img src="img/{{($row->is_active)?'check.png':'close.png'}}"></td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Created by')}}</td>
                <td width="75%" class="align-left">{{@$row->creator->name}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Views')}}</td>
                <td width="75%" class="align-left">{{@$row->views}}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
