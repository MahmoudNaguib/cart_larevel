<div class="row mg-t-20 form-group">
    <label class="col-sm-3 form-control-label">{{ @$attributes['label'] }} <span class="tx-danger">{{ (@$attributes['required'])?'*':'' }}</span></label>
    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
        {!! Form::password($name,$attributes)!!}
        @if(@$errors)
            @foreach($errors->get($name) as $message)
            <span class='help-inline text-danger'>{{ $message }}</span>
            @endforeach
        @endif
    </div>
</div>
