@if(!auth()->guest())
    <div class="slim-navbar">
        <div class="container">
            <ul class="nav">
                <li class="nav-item {{(request()->is('*/admin/dashboard*'))?"active":""}}">
                    <a class="nav-link" href="{{app()->make("url")->to('/')}}/{{lang()}}/admin/dashboard">
                        <i class="icon ion-ios-pie-outline"></i>
                        <span>{{trans('app.Dashboard')}}</span>
                    </a>
                </li>
                <li class="nav-item with-sub {{(request()->is('*/admin/categories*') || request()->is('*/admin/products*') || request()->is('*/admin/orders*'))?"active":""}}">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="icon ion-ios-cart-outline"></i>
                        <span>{{trans('app.Catalog')}}</span>
                    </a>
                    <div class="sub-item">
                        <ul>
                            @if(can('create-categories') || can('view-categories'))
                                <li class="{{(request()->is('*/admin/categories*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/categories">{{trans('app.Categories')}}</a>
                                </li>
                            @endif
                            @if(can('create-products') || can('view-products'))
                                <li class="{{(request()->is('*/admin/products*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/products">{{trans('app.Products')}}</a>
                                </li>
                            @endif
                            @if(can('view-orders'))
                                <li class="{{(request()->is('*/admin/orders*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/orders">{{trans('app.Orders')}}</a>
                                </li>
                            @endif
                            @if(can('view-reviews'))
                                <li class="{{(request()->is('*/admin/reviews*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/reviews">{{trans('app.Reviews')}}</a>
                                </li>
                            @endif
                            @if(can('create-vouchers') || can('view-vouchers'))
                                <li class="{{(request()->is('*/admin/vouchers*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/vouchers">{{trans('app.Vouchers')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>

                <li class="nav-item with-sub {{(request()->is('*/admin/sections*') || request()->is('*/admin/posts*'))?"active":""}}">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="icon ion-ios-list"></i>
                        <span>{{trans('app.BLog')}}</span>
                    </a>
                    <div class="sub-item">
                        <ul>
                            @if(can('create-sections') || can('view-sections'))
                                <li class="{{(request()->is('*/admin/sections*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/sections">{{trans('app.Section')}}</a>
                                </li>
                            @endif
                            @if(can('create-posts') || can('view-posts'))
                                <li class="{{(request()->is('*/admin/posts*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/posts">{{trans('app.Posts')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>


                @if(can('create-users') || can('view-users'))
                    <li class="nav-item {{(request()->is('*/admin/users*'))?"active":""}}">
                        <a class="nav-link" href="{{lang()}}/admin/users">
                            <i class="icon ion-ios-contact"></i>
                            <span>{{trans('app.Users')}}</span>
                        </a>
                    </li>
                @endif


                <li class="nav-item with-sub {{(
                request()->is('*/admin/roles*') || 
                request()->is('*/admin/configs*') ||
                request()->is('*/admin/pages*') || 
                request()->is('*/admin/slides*') || 
                 request()->is('*/admin/countries*') ||
                  request()->is('*/admin/currencies*') ||
                   request()->is('*/admin/messages*') || 
                   request()->is('*/admin/contacts*'))?"active":""}}">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        <i class="icon ion-ios-gear-outline"></i>
                        <span>{{trans('app.Others')}}</span>
                    </a>
                    <div class="sub-item">
                        <ul>
                            @if(@auth()->user()->role_id==1)
                                <li class="{{(request()->is('*/admin/roles*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/roles">{{trans('app.Roles')}}</a>
                                </li>
                                <li class="{{(request()->is('*/admin/admin/configs*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/configs/edit">{{trans('app.Configurations')}}</a>
                                </li>
                            @endif
                            @if(can('create-pages') || can('view-pages'))
                                <li class="{{(request()->is('*/admin/pages*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/pages">{{trans('app.Pages')}}</a>
                                </li>
                            @endif
                            @if(can('create-slides') || can('view-slides'))
                                <li class="{{(request()->is('*/admin/slides*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/slides">{{trans('app.Slides')}}</a>
                                </li>
                            @endif
                            @if(can('create-countries') || can('view-countries'))
                                <li class="{{(request()->is('*/admin/countries*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/countries">{{trans('app.Countries')}}</a>
                                </li>
                            @endif

                            @if(can('create-currencies') || can('view-currencies'))
                                <li class="{{(request()->is('*/admin/currencies*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/currencies">{{trans('app.Currencies')}}</a>
                                </li>
                            @endif

                            @if(can('view-messages'))
                                <li class="{{(request()->is('*/admin/messages*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/messages">{{trans('app.Contact us messages')}}</a>
                                </li>
                            @endif

                            @if(can('view-contacts'))
                                <li class="{{(request()->is('*/admin/contacts*'))?"active":""}}"><a
                                        href="{{lang()}}/admin/contacts">{{trans('app.Newsletter contacts')}}</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
@endif