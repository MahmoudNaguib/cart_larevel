@extends('emails.master')

@section('title'){{trans("email.Confirm User account")}}@endsection

@section('content')

<p>{{trans("email.Welcome")}} <strong>{{$row->name}}</strong></p>
<p>{{trans("email.Thanks for joining us at")}} {{ appName() }}</p>
<p>
    {{trans("email.Here is your account details")}}
</p>
<p>
    @if(@$row->role_id)
    <strong>{{trans("email.Role")}} : </strong> {{$row->role->title}} <br>
    @endif
    @if(@$row->country_id)
    <strong>{{trans("email.Country")}} : </strong> {{$row->country->title}} <br>
    @endif

    @if($row->name)
    <strong>{{trans("email.Name")}} : </strong> {{$row->name}} <br>
    @endif

    @if($row->email)
    <strong>{{trans("email.Email")}} : </strong> {{$row->email}} <br>
    @endif

    @if($row->mobile)
    <strong>{{trans("email.Mobile")}} : </strong> {{$row->mobile}} <br>
    @endif

    @if(!$row->confirmed)
<p>{{trans('email.To confirm your account please click the link below')}}</p>
<a href="{{App::make("url")->to('/')}}/auth/confirm/{{$row->confirm_token}}">{{App::make("url")->to('/')}}/auth/confirm/{{ $row->confirm_token }}</a>
@endif
</p>
@endsection
