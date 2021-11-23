@extends('emails.master')

@section('title'){{ trans('email.New notification') . '-' . appName() }} @endsection

@section('content')
<h2>{{trans("email.New Notification Has Been Received")}}</h2>
<p>
    <label>
        <strong>{{trans("email.Dear")}} {{ $row->to->name }}</strong> ,
    </label>
</p>
<p>
    {{$row->title}}
</p>    
<p>
    {{$row->content}}
</p>
<a href="{{ url($row->url) }}">{{ trans('email.Check it') }}</a>
</p>
@endsection
