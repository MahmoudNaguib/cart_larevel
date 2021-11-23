@extends('layouts.admin')
@section('title')
<h2 class="register-title">{{$page_title}}</h2>
@endsection
@section('content')
<div class="col-md-12">
    {!! Form::model($row,['method' => 'post','files' => true] ) !!}
    {{ csrf_field() }}

    @include('form.input',['name'=>'name','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Name'),'placeholder'=>trans('app.Name'),'required'=>1]])

    @include('form.input',['name'=>'mobile','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Mobile'),'placeholder'=>trans('app.Mobile'),'required'=>1]])

    @include('form.select',['name'=>'country_id','options'=>$row->getCountries(),'attributes'=>['class'=>'form-control','label'=>trans('app.Country'),'placeholder'=>trans('app.Country'),'required'=>1]])

    @include('form.select',['name'=>'currency_id','options'=>$row->getCurrencies(),'attributes'=>['class'=>'form-control','label'=>trans('app.Default currency'),'placeholder'=>trans('app.Default currency'),'required'=>1]])

    @include('form.select',['name'=>'language','options'=>languages(),'attributes'=>['class'=>'form-control','label'=>trans('app.Default language'),'placeholder'=>trans('app.Default language'),'required'=>1]])

    @include('form.file',['name'=>'image','attributes'=>['class'=>'form-control custom-file-input','label'=>trans('app.Avatar'),'placeholder'=>trans('app.Avatar')]])

    <!-- form-group -->
    <button class="btn btn-primary btn-block btn-signin pt-150">{{ trans('app.Submit') }}</button>
    {!! Form::close() !!}
</div>
@endsection
