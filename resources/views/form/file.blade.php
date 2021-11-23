<div class="row mg-t-20 form-group">
    <label class="col-sm-3 form-control-label">{{ @$attributes['label'] }} <span class="tx-danger">{{ (@$attributes['required'])?'*':'' }}</span></label>
    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
        <div class="custom-file">
            {!! Form::file($name,$attributes)!!}
            <label class="custom-file-label" for="{{ @$id }}">{{ trans('app.Choose') }}</label>
            @if(!$errors->isEmpty())
            @foreach($errors->get($name) as $message)
            <span class='help-inline text-danger'>{{ $message }}</span>
            @endforeach
            <br>
            @endif

            @php
            $value=(@$attributes['value'])?:$row->$name;
            @endphp
            @if(@$attributes['file_type'] == 'attachment' )
            <span class="imagePreview"> {!! attach($value) !!}</span>
            <br>
            @else
            <span class="imagePreview"> {!! image($value,'small',['width'=>50]) !!}</span>
            <br><br>
            @endif
        </div>
    </div>
</div>
