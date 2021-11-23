@extends('emails.master')

@section('title'){{trans('email.Contact us submit form')}} - {{$row->name}} @endsection

@section('content')
<h2>{{trans('email.Contact us submit form')}} - {{$row->name}}</h2>
<p>
    <strong>{{trans("email.Name")}} </strong> :  {{$row->name}}
<p>
<p>
    <strong>{{trans("email.Email")}} </strong> :  {{$row->email}}
<p>
<p>
    <strong>{{trans("email.Content")}} </strong> :  {!! $row->content !!}
<p>
@endsection
