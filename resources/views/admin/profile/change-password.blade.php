@extends('layouts.admin')
@section('title')
<h2 class="register-title">{{$page_title}}</h2>
@endsection
@section('content')
<div class="col-md-12">
    {!! Form::model($row,['method' => 'post','files' => true] ) !!} 
    {{ csrf_field() }}
    @include('form.password',['name'=>'old_password','attributes'=>['class'=>'form-control','label'=>trans('app.Old password'),'placeholder'=>trans('app.Old password'),'required'=>1]])
    
    @include('form.password',['name'=>'password','attributes'=>['class'=>'form-control','label'=>trans('app.Password'),'placeholder'=>trans('app.Password'),'required'=>1]])

    @include('form.password',['name'=>'password_confirmation','attributes'=>['class'=>'form-control','label'=>trans('app.Password confirmation'),'placeholder'=>trans('app.Password confirmation'),'required'=>1]])
    <!-- custom-file -->
    <button class="btn btn-primary btn-block btn-signin">{{ trans('app.Submit') }}</button>
    {!! Form::close() !!}
</div>
@endsection
