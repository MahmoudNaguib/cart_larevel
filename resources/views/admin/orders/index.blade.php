@extends('layouts.admin')
@section('title')
<h6 class="slim-pagetitle">
    {{ @$page_title }}
    @if(can('view-'.$module))
    <a href="{{lang()}}/admin/{{$module}}/export?{{@$_SERVER['QUERY_STRING']}}" class="btn btn-primary">
        <i class="fa fa-arrow-down"></i> {{trans('app.Export')}}
    </a>
    @endif
</h6>
@endsection
@section('content')
<div class="section-wrapper">
    @include('admin.'.$module.'.partials.filters')
    @if(can('view-'.$module))
    @if (!$rows->isEmpty())
    <div class="table-responsive">
        <table class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-5p">{{trans('app.ID')}} </th>
                    <th class="wd-15p">{{trans('app.Contact name')}}</th>
                    <th class="wd-10p">{{trans('app.Contact mobile')}}</th>
                    <th class="wd-10p">{{trans('app.SubTotal')}}</th>
                    <th class="wd-5p">{{trans('app.Voucher value')}}</th>
                    <th class="wd-10p">{{trans('app.Total')}}</th>
                    <th class="wd-10p">{{trans('app.Status')}} </th>
                    <th class="wd-10p">{{trans('app.Created by')}} </th>
                    <th class="wd-15p">{{trans('app.Created at')}}</th>
                    <th class="wd-20p">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                <tr>
                    <td class="center">{{$row->id}}</td>
                    <td class="center">{{$row->contact_name}}</td>
                    <td class="center">{{$row->contact_mobile}}</td>
                    <td class="center">{{$row->sub_total}} {{$row->currency->title}}</td>
                    <td class="center">{{$row->voucher_amount}} {{$row->currency->title}}</td>
                    <td class="center">{{$row->total}} {{$row->currency->title}}</td>
                    <td class="center">
                        @if(can('change-status-'.$module))
                        <a href="{{$module}}/change-status/{{$row->id}}" title="{{trans('app.Change status')}}" data-toggle="modal" data-target="#chage-status-{{$row->id}}" class="">
                            {{$row->status}}
                            <i class="fa fa-edit"></i>
                        </a>
                        <div class="modal fade" id="chage-status-{{$row->id}}" role="document">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content bd-0">
                                    <div class="modal-header pd-y-20 pd-x-25">
                                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">{{trans('app.Status')}}</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body pd-25">
                                        {!! Form::open(['url'=>lang().'/admin/'.$module.'/change-status/'.$row->id,'method' => 'post','files' => true] ) !!}
                                        {{ csrf_field() }}
                                        <div class="row mg-t-20">
                                            <label class="col-sm-4 form-control-label text-wrap ">{{ trans('app.Status') }} <span class="tx-danger">*</span></label>
                                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                                {!! Form::select('status', $row->getStatueses(),@$row->status, ['class'=>'form-control','label'=>trans('app.Status'),'placeholder'=>trans('app.Status'),'required'=>1]) !!}

                                            </div>
                                        </div>
                                        <!-- custom-file -->
                                        <div class="form-layout-footer mg-t-30">
                                            <button class="btn btn-primary bd-0">{{ trans('app.Save') }}</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div><!-- modal-dialog -->
                        </div>
                        @endif
                    </td>
                    <td class="center">{{@$row->creator->name}}</td>
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
        {!! $rows->appends(['from_date','to_date','created_by'])->render() !!}
    </div>
    @else
    {{trans("app.There is no results")}}
    @endif
    @endif
</div>
@endsection
