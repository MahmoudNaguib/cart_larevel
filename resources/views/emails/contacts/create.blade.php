@extends('emails.master')

@section('title'){{trans('email.Contact us submit form')}} - {{$row->name}} @endsection

@section('content')
    <p>{{trans('app.You have subscribed to our newsletter')}}</p>
@endsection
