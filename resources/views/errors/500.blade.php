@extends('layouts.errors')
@section('title')
    <h2 class="register-title">
        500 {{trans('app.Server is down')}}
    </h2>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <h3 class="signin-title-secondary">
                    {{trans('app.Click the home page to navigate')}}
                </h3>

            </div>
            <div class="col-md-6 text-right">
                <img class="img-fluid" src="img/error.gif" alt="error">
            </div>
        </div>
    </div>
@endsection
