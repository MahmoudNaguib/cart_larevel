<div class="mg-b-10">
    {!! Form::model($row,['method' => 'get','files' => true] ) !!}
    <label class="section-title">{{ trans('app.Filter by')}}</label>
    <div class="row">
        <div class="col-lg-3 col-md-6 mg-t-10">
            {!! Form::select('created_by',  $row->getUsers(),@request('created_by'), ['class'=>'form-control select2','placeholder'=>trans('app.User')]) !!}
        </div><!-- col-4 -->
        <div class="col-lg-3 col-md-6 mg-t-10">
            {!! Form::text('from_date', request('from_date'), ['class'=>'form-control datepicker','placeholder'=>trans('app.From'),'autocomplete'=>'off']) !!}

        </div><!-- col-4 -->
        <div class="col-lg-3 col-md-6 mg-t-10">
            {!! Form::text('to_date',request('to_date'), ['class'=>'form-control datepicker','placeholder'=>trans('app.To'),'autocomplete'=>'off']) !!}
        </div><!-- col-4 -->
        <div class="col-lg-3 col-md-6 mg-t-10">
            <button class="btn btn-primary col-lg-5 col-md-5 mg-b-10">{{ trans('app.Filter') }}</button>
            <a href="{{lang()}}/admin/{{$module}}" class="btn btn-primary col-lg-5 col-md-5 mg-b-10">{{ trans('app.Reset') }}</a>
        </div>
    </div><!-- row -->
    {!! Form::close() !!}
</div><!-- section-wrapper -->
