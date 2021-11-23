<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
    <head>
        @include('admin.partials.meta')
        @include('admin.partials.css')
        @stack('css')
    </head>

    <body>
        <div class="slim-header darkHeader">
            <div class="container">
                <div class="slim-header-left">
                    @include('admin.partials.logo')
                    @if(@auth()->user()->role_id)
                        @include('admin.partials.search')
                    @endif
                    <!-- search-box -->
                </div>
                <!-- slim-header-left -->
                <div class="slim-header-right">
                    @if(@auth()->user())
                        @include('admin.notifications.notifications')
                    @endif
                    @include('admin.partials.langSwitch')
                    @include('admin.partials.user_navigation')
                </div>
                <!-- header-right -->
            </div>
            <!-- container -->
        </div>
        <!-- slim-header -->
        @if(@auth()->user()->role_id)
            @include('admin.partials.navigation')
        @endif
        <!-- slim-navbar -->

        <div class="slim-mainpanel">
            <div class="container">
                @include('admin.partials.breadcrumb')
                @include('admin.partials.flash_messages')
                <!-- section-wrapper -->
                @yield('content')
                <!-- section-wrapper -->
            </div>
            <!-- container -->
        </div>
        <!-- slim-mainpanel -->
        <!-- slim-footer -->
        @include('admin.partials.footer')
        @include('admin.partials.js')
        @stack('js')
    </body>

</html>
