@extends('layouts.admin')
@section('title')
<h2 class="register-title">{{$page_title}}</h2>
@endsection
@section('content')
<div class="col-md-12">
    {!! Form::open(['method' => 'post'] ) !!} 
    {{ csrf_field() }}
    @include('form.input',['name'=>'name','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Name'),'placeholder'=>trans('app.Full name'),'autocomplete'=>"off",'required'=>1]])

    @include('form.input',['name'=>'email','type'=>'email','attributes'=>['class'=>'form-control','label'=>trans('app.Email'),'placeholder'=>trans('app.Email'),'autocomplete'=>"off",'required'=>1]])

    @include('form.input',['name'=>'mobile','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Mobile'),'placeholder'=>trans('app.Mobile'),'autocomplete'=>"off",'required'=>1]])

    @include('form.password',['name'=>'password','attributes'=>['class'=>'form-control','label'=>trans('app.Password'),'placeholder'=>trans('app.Password'),'autocomplete'=>"off",'required'=>1]])

    @include('form.password',['name'=>'password_confirmation','attributes'=>['class'=>'form-control','label'=>trans('app.Password confirmation'),'placeholder'=>trans('app.Password confirmation'),'autocomplete'=>"off",'required'=>1]])
    @if(env('ENABLE_CAPTCHA') == 1)
    <script src='https://www.google.com/recaptcha/api.js?hl={{lang()}}&manual_challenge=false'></script>
    @php $input = "g-recaptcha-response"; @endphp
    <div class="form-group {{ $errors->has($input) ? 'has-error' : '' }}">
        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_CAPTCHA_KEY') }}"></div>
        @foreach($errors->get($input) as $message)
        <span class='help-inline text-danger'>{{ $message }}</span>
        @endforeach
    </div>
    @endif
    <!-- form-group -->
    <button class="btn btn-primary btn-block">{{ trans('app.Submit') }}</button>
    {!! Form::close() !!}
    <p class="mg-b-0">
        <a href="{{lang()}}/auth/forgot-password">{{ trans('app.Forgot password') }}</a> | <a href="{{lang()}}/auth/login">{{ trans('app.Login') }}</a>
    </p>
    {!! Form::close() !!}
</div>
@endsection
