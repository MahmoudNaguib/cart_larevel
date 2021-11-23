@php
    $notifications = auth()->user()->notifications()->unreaded()->latest()->get();
@endphp

@if(@$notifications)
    <a href="{{lang()}}/admin/notifications" class="header-notification">
        <i class="icon ion-ios-bell-outline"></i>
        @if(!@$notifications->isEmpty())
            <span class="indicator">{{$notifications->count()}}</span>
        @endif
    </a>
@endif

