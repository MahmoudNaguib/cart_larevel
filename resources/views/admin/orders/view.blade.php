@extends('layouts.admin')
@section('title')
<h6 class="slim-pagetitle">
    {{ @$page_title }}
</h6>
@endsection
@section('content')
<div class="section-wrapper">
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
            <tr>
                <td width="25%" class="align-left">{{trans('app.Contact name')}}</td>
                <td width="75%" class="align-left">{{$row->contact_name}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Contact mobile')}}</td>
                <td width="75%" class="align-left">{{$row->contact_mobile}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Address')}}</td>
                <td width="75%" class="align-left">{{$row->full_address}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Status')}}</td>
                <td width="75%" class="align-left">{{$row->status}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Created at')}}</td>
                <td width="75%" class="align-left">{{$row->created_at}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Create by')}}</td>
                <td width="75%" class="align-left">{{$row->creator->name}}</td>
            </tr>
            <tr>
                <td width="25%" class="align-left">{{trans('app.Products')}}</td>
                <td width="75%" class="align-left">
                    @if($row->products_list)
                        <table class="table display responsive nowrap">
                            <thead>
                            <tr>
                                <th class="wd-5p">{{trans('app.ID')}} </th>
                                <th class="wd-10p">{{trans('app.Category')}} </th>
                                <th class="wd-5p">{{trans('app.Image')}} </th>
                                <th class="wd-25p">{{trans('app.Product')}} </th>
                                <th class="wd-10p">{{trans('app.Unit price')}} </th>
                                <th class="wd-10p">{{trans('app.Quantity')}} </th>
                                <th class="wd-10p">{{trans('app.Total')}} </th>
                            </tr>
                            </thead>
                            @foreach($row->products_list as $product)
                                <tbody>
                                <tr>
                                    <td class="center">{{$product->product_id}}</td>
                                    <td class="center">{{$product->category}}</td>
                                    <td class="center">{!! image($product->product_image,'small',['width'=>30]) !!}</td>
                                    <td class="center">{{$product->product_title}}</td>

                                    <td class="center">{{$product->price}} {{$product->currency}}</td>
                                    <td class="center">{{$product->quantity}}</td>
                                    <td class="center">{{$product->total}} {{$product->currency}}</td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                        <div class="total_desccription">
                            <p>
                                <label>{{trans('app.SubTotal')}}</label> : {{$row->sub_total}} {{$row->currency->title}}
                            </p>
                            @if($row->voucher_id)
                                <p>
                                    <label>{{trans('app.Voucher code')}}</label> : {{$row->voucher->code}}
                                </p>
                                <p>
                                    <label>{{trans('app.Voucher value')}}</label> : {{$row->voucher_amount}} {{$row->currency->title}}
                                </p>
                            @endif
                            <p>
                                <label>{{trans('app.Total')}}</label> : {{$row->total}} {{$row->currency->title}}
                            </p>
                        </div>
                    @endif

                    <h4>{{trans('email.Shipping details')}}</h4>
                    @if(isset($row->contact_name))
                        <strong>{{trans("app.Contact name")}} : </strong> {{$row->contact_name}} <br>
                    @endif
                    @if(isset($row->contact_mobile))
                        <strong>{{trans("app.Contact mobile")}} : </strong> {{$row->contact_mobile}} <br>
                    @endif

                    @if(isset($row->full_address))
                        <strong>{{trans("app.Address")}} : </strong> {{$row->full_address}} <br>
                    @endif

                    @if(isset($row->status))
                        <strong>{{trans("app.Status")}} : </strong> {{$row->status}} <br>
                    @endif

                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
