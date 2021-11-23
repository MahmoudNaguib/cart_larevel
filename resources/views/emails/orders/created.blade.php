@extends('emails.master')

@section('title'){{trans("email.New order created")}}-#{{$row->id}}-{{ appName() }}@endsection

@section('content')

<p>{{trans("email.Your order has been placed")}}, #{{$row->id}}</p>
<p>
    {{trans("email.Here is your order details")}}
</p>

@if(isset($row->status))
<strong>{{trans("email.Status")}} : </strong> {{$row->status}} <br>
@endif

@if($row->products_list)
<table class="table display responsive nowrap" style="border: 1px solid #ced4da;">
    <thead>
        <tr>
            <th class="wd-5p">{{trans('admin.ID')}} </th>
            <th class="wd-5p">{{trans('admin.Image')}} </th>
            <th class="wd-25p">{{trans('admin.Product')}} </th>
            <th class="wd-25p">{{trans('admin.Section')}} </th>
            <th class="wd-10p">{{trans('admin.Unit price')}} </th>
            <th class="wd-10p">{{trans('admin.Quantity')}} </th>
            <th class="wd-10p">{{trans('admin.Total')}} </th>
        </tr>
    </thead>
    @foreach($row->products_list as $product)
    <tbody>
        <tr>
            <td class="center">{{$product->product_id}}</td>
            <td class="center">{!! image($product->product_image,'small',['width'=>30]) !!}</td>
            <td class="center">{{$product->product_title}}</td>
            <td class="center">{{$product->section}}</td>
            <td class="center">{{$product->product_price}} {{$product->currency}}</td>
            <td class="center">{{$product->product_quantity}}</td>
            <td class="center">{{$product->total}} {{$product->currency}}</td>
        </tr>
    </tbody>
    @endforeach
</table>


<div class="total_desccription">
    <p>
        <label>{{trans('email.SubTotal')}}</label> : {{$row->sub_total}} {{$row->currency->title}}
    </p>
    @if($row->voucher_id)
    <p>
        <label>{{trans('email.Voucher code')}}</label> : {{$row->voucher->code}}
    </p>
    <p>
        <label>{{trans('email.Voucher amount')}}</label> : {{$row->voucher_amount}} {{$row->currency->title}}
    </p>
    @endif
    <p>
        <label>{{trans('email.Total')}}</label> : {{$row->total}} {{$row->currency->title}}
    </p>
</div>
@endif


<h4>{{trans('email.Shipping details')}}</h4>
@if(isset($row->contact_name))
<strong>{{trans("email.Contact name")}} : </strong> {{$row->contact_name}} <br>
@endif

@if(isset($row->contact_mobile))
<strong>{{trans("email.Contact mobile")}} : </strong> {{$row->contact_mobile}} <br>
@endif

@if(isset($row->full_address))
<strong>{{trans("email.Address")}} : </strong> {{$row->full_address}} <br>
@endif




@endsection
