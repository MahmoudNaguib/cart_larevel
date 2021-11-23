<div class="slim-footer">
    <div class="container">
        <p class="copyright text-center">
            <a href="{{app()->make("url")->to('/')}}" target="_blank">{{appName()}} {{date('Y')}}</a> 
            {{(env('APP_ENV')!='production')?env('APP_ENV'):''}}
        </p>
    </div><!-- container -->
</div>