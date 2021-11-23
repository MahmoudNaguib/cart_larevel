{{--
@if(@auth()->user()->is_admin)
{!! Form::open(['url'=>lang().'/admin/search','method' => 'get','name'=>'search'] ) !!} 
<div class="search-box">
    <input type="text" name="q" class="form-control" placeholder="{{ trans('app.Search') }}" value="{{request('q')}}">
    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
</div>
{!! Form::close() !!}
@endif--}}
