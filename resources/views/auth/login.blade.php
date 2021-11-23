@extends('layouts.admin')
@section('title')
<h2 class="register-title">{{$page_title}}</h2>
@endsection
@section('content')
<div class="col-md-12">
    {!! Form::model($row,['method' => 'post','files' => true] ) !!} 
    {{ csrf_field() }}
    @include('form.input',['name'=>'email','type'=>'email','attributes'=>['class'=>'form-control','label'=>trans('app.Email'),'placeholder'=>trans('app.Email'),'autocomplete'=>"off",'required'=>1]])

    @include('form.password',['name'=>'password','attributes'=>['class'=>'form-control','label'=>trans('app.Password'),'placeholder'=>trans('app.Password'),'required'=>1]])
    <div class="form-group">
        <label class="ckbox">
            <input type="checkbox" name="remember_me"><span>{{trans('app.Remember me')}}</span>
        </label>
    </div>
    <!-- form-group -->
    <button class="btn btn-primary btn-block">{{ trans('app.Submit') }}</button>
    <a href="{{lang()}}/auth/forgot-password">{{ trans('app.Forgot password') }}</a> | 
    <a href="{{lang()}}/auth/register">{{ trans('app.Register') }}</a>
    {!! Form::close() !!}
</div>
@endsection



