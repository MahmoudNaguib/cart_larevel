<div class="row mg-t-20 form-group">
    <label class="col-sm-3 form-control-label">{{ @$attributes['label'] }} <span class="tx-danger">{{ (@$attributes['required'])?'*':'' }}</span></label>
    <div class="col-sm-9 mg-t-10 mg-sm-t-0">

        <div class="row mg-t-10">
            <div class="col-lg-4">
                <label class="rdiobox">
                    {!! Form::radio($name,1,null,$attributes) !!}
                    <span>{{trans('app.Yes')}} </span>
                </label>
            </div><!-- col-3 -->
            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                <label class="rdiobox">
                    {!! Form::radio($name,0,null,$attributes) !!}
                    <span>{{trans('app.No')}} </span>
                </label>
            </div><!-- col-3 -->
            @if(@$errors)
            @foreach($errors->get($name) as $message)
            <span class='help-inline text-danger'>{{ $message }}</span>
            @endforeach
            @endif
        </div>


    </div>
</div>



