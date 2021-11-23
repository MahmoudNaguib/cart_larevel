<style>
    p{
        line-height: 30px;
        font-size: 14px;
        color: #000;
    }
    .footer{
        color: #999999;
        font-size: 12px;
        text-align: center;
    }
    .footer a, .footer a:hover, .footer a:focus,.footer a:active{
        color: #999999;
        text-decoration: none;
    }
</style>
<p>
    <img src="{{App::make("url")->to('/')}}/{{uploads()}}/small/{{conf('logo')}}" alt="{{ appName() }}" height="50">
</p>
<hr>
<h3 style="text-align: center;">@yield('title')</h3>

<p>@yield('content')</p>

<p class="footer">
    {{ trans('email.Copyright') }} {{date("Y")}} ©
    <a href="{{App::make("url")->to('/')}}">
        {{ appName() }}
    </a>
</p>
