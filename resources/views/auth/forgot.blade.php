@extends('layouts.admin')
@section('title')
<h2 class="register-title">{{$page_title}}</h2>
@endsection
@section('content')
<div class="col-md-12">
    {!! Form::model($row,['method' => 'post','files' => true] ) !!} 
    {{ csrf_field() }}
    @include('form.input',['type'=>'email','name'=>'email','attributes'=>['class'=>'form-control','label'=>trans('app.Email'),'placeholder'=>trans('app.Email'),'required'=>1]])
    <!-- form-group -->
    <button class="btn btn-primary btn-block">{{ trans('app.Submit') }}</button>
    <a href="auth/login">{{ trans('app.Login') }}</a> |
    <a href="auth/register">{{ trans('app.Register') }}</a>
    {!! Form::close() !!}
</div>
@endsection



