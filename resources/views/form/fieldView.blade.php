<div class="row mg-t-20 form-group">
    <label class="col-sm-3"><b>{{ @$attributes['label'] }}</b></label>
    <div class="col-sm-9 mg-t-10 mg-sm-t-0">
        @if(isset($attributes['type']))
            @if(@$attributes['type'] == 'image' )
                {!! image(@$attributes['value'],'small') !!}
            @else
               {!! file(@$attributes['value']) !!}
            @endif
        @else
        {{@$attributes['value']}}
        @endif
    </div>
</div>
