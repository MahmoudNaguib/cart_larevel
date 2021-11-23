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

            @foreach(langs() as $lang)
            <tr>
                <td width="25%" class="align-left">{{trans('app.Title')}} {{$lang}}</td>
                <td width="75%" class="align-left">{{@$row->getTranslation('title',$lang)}}</td>
            </tr>
            @endforeach
            <tr>
                <td width="25%" class="align-left">{{trans('app.Image')}}</td>
                <td width="75%" class="align-left">{!! image($row->image,'small') !!}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Created by')}}</td>
                <td width="75%" class="align-left">{{@$row->creator->name}}</td>
            </tr>

        </table>
    </div>
</div>
@endsection
