@extends('emails.master')

@section('title'){{trans("email.Confirm User account")}}@endsection

@section('content')

<p>{{trans("email.Welcome")}} <strong>{{$row->name}}</strong></p>
<p>{{trans("email.Thanks for joining us at")}} {{ appName() }}</p>
<p>
    {{trans("email.Here is your account details")}}
</p>
<p>
    @if($row->name)
    <strong>{{trans("email.Name")}} : </strong> {{$row->name}} <br>
    @endif

    @if($row->email)
    <strong>{{trans("email.Email")}} : </strong> {{$row->email}} <br>
    @endif

    @if($password)
    <strong>{{trans("email.New Password")}} : </strong> {{@$password}} <br>
    @endif
    
</p>
@endsection
