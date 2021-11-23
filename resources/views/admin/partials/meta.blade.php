<!-- Required meta tags -->
@if (app()->environment() != 'production')
<meta name="robots" content="noindex">
@endif
<meta charset="utf-8">
<base href="{{app()->make("url")->to('/')}}/" />
<title>{{appName()}} :: {{strip_tags(@$page_title)}}</title>
<meta name="description" content="{{@$meta_description}}">
<meta name="keywords" content="{{@$meta_keywords}}">
<meta name="author" content="{{conf('application_name')}}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="language" content="{{(lang()=='ar')?'Arabic':'English'}}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="img/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
<link rel="manifest" href="img/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="img/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<meta property="og:locale" content="{{(lang() == 'en')?'en_EG':'ar_EG'}}">
<meta property="og:type" content="website">
<link rel="canonical" href="{{App::make("url")->to('/')}}/{{Request::path()}}" />
<meta property="og:title" content="{{conf('application_name')}} - {{@$page_title}}"/>
<meta property="og:url" content="{{App::make("url")->to('/')}}/{{Request::path()}}"/>
<meta property="og:site_name" content="{{conf('application_name')}}"/>
<meta property="og:locale" content="{{(lang()=='ar')?'ar_EG':'en_US'}}"/>
<meta property="og:description" content="{{@$meta_description}}" />
<meta property="og:image:width" content="500" />
<meta property="og:image:height" content="500" />
<meta property="og:image" content="{{app()->make("url")->to('/')}}/uploads/large/share.png" />
<meta property="fb:app_id" content="2417803741600196" />
<meta name="google-site-verification" content="2ky_EVfIhCmJcCKBhW0PsYxIaoeueWwAiMRnnSN5V9U" />