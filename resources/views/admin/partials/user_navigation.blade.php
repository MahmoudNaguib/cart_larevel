@if(auth()->user())
<div class="dropdown dropdown-c">
    <a href="#" class="logged-user" data-toggle="dropdown">
        {!!image(auth()->user()->image,'small') !!}
        <span>{{ auth()->user()->name }}</span>
        <i class="fa fa-angle-down"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <nav class="nav">
            <a href="{{lang()}}/admin/profile/edit" class="nav-link"><i class="icon ion-person"></i> {{ trans('app.Edit account') }}</a>
            <a href="{{lang()}}/admin/profile/change-password" class="nav-link"><i class="icon ion-person"></i> {{ trans('app.Change password') }}</a>
            <a href="{{lang()}}/admin/profile/logout" class="nav-link"><i class="icon ion-forward"></i>{{ trans('app.Logout') }}</a>
        </nav>
    </div>
    <!-- dropdown-menu -->
</div>
<!-- dropdown -->
@else
<div class="dropdown dropdown-c">
    <a href="{{lang()}}/auth/login" class="logged-user" >
        <span>{{trans('app.Login')}}</span>
        <i class="fa fa-angle-down"></i>
    </a>
</div>
@endif