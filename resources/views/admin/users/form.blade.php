@include('form.input',['name'=>'name','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Name'),'placeholder'=>trans('app.Name'),'required'=>1]])

@include('form.input',['name'=>'email','type'=>'email','attributes'=>['class'=>'form-control','label'=>trans('app.Email'),'placeholder'=>trans('app.Email'),'required'=>1]])

@include('form.input',['name'=>'mobile','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Mobile'),'placeholder'=>trans('app.Mobile'),'required'=>1]])

@php
    $attributes=['class'=>'form-control','label'=>trans('app.Password'),'placeholder'=>trans('app.Password'),'required'=>1];
    if(@$row->id) unset($attributes['required']);
@endphp

@include('form.password',['name'=>'password','attributes'=>$attributes])

@php
    $attributes=['class'=>'form-control','label'=>trans('app.Password confirmation'),'placeholder'=>trans('app.Password confirmation'),'required'=>1];
    if(@$row->id) unset($attributes['required']);
@endphp
@include('form.password',['name'=>'password_confirmation','attributes'=>$attributes])

@include('form.select',['name'=>'country_id','options'=>$row->getCountries(),'attributes'=>['class'=>'form-control','label'=>trans('app.Country'),'placeholder'=>trans('app.Country'),'required'=>1]])

 @include('form.select',['name'=>'currency_id','options'=>$row->getCurrencies(),'attributes'=>['class'=>'form-control','label'=>trans('app.Default currency'),'placeholder'=>trans('app.Default currency'),'required'=>1]])

@include('form.select',['name'=>'language','options'=>languages(),'attributes'=>['class'=>'form-control','label'=>trans('app.Default language'),'placeholder'=>trans('app.Default language'),'required'=>1]])

@include('form.file',['name'=>'image','attributes'=>['class'=>'form-control custom-file-input','label'=>trans('app.Avatar'),'placeholder'=>trans('app.Avatar')]])


<h3>{{trans('app.Admin Roles')}}</h3>
@include('form.select',['name'=>'role_id','options'=>$row->getRoles(),'attributes'=>['class'=>'form-control','label'=>trans('app.Role'),'placeholder'=>trans('app.Role')]])
