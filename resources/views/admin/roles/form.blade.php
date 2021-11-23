@include('form.input',['name'=>'title','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Title'),'placeholder'=>trans('app.Title'),'required'=>1]])

@if(config('modules'))
@foreach(config('modules') as $key=>$permissions)
<h5 class="mg-b-10 mg-t-20">
    <label class="ckbox">
        {!! Form::checkbox('parents',NULL,null,['id'=>toId($key),'class'=>'parents']) !!}
        <span><b><u>{{ucfirst($key)}}</u></b></span>
    </label>
</h5>
<div class="row">
    @foreach ($permissions as $permission=>$label)
    <div class="col-lg-3">
        <label class="ckbox">
            {!! Form::checkbox('permissions[]',$permission,null,['id'=>$permission,'class'=>'childs childs_'.toId($key),'for'=>toId($key)]) !!}
            <span>{{$label}}</span>
        </label>
    </div>
    @endforeach
</div>
@endforeach
@endif
@if(@$errors)
@foreach($errors->get('permissions') as $message)
<span class='help-inline text-danger'>{{trans('app.Choose at least 1 permission')}}</span>
@endforeach
@endif

@push('js')
<script>
    $('.parents').on('change',function(){
        if ($(this).is(':checked')) {
            $('.childs_'+$(this).attr('id')).prop('checked', true);
        }
        else{
            $('.childs_'+$(this).attr('id')).prop('checked', false);
        }
    });
    $('.childs').on('change',function(){
        var parent=$(this).attr("for");
        if ($(this).is(':checked')) {
            $('#'+parent).prop('checked', true);
        }
        else{
            if($('.childs_'+parent+":checked").size() ==0){
                $('#'+parent).prop('checked', false);
            }
        }
    });
    $('.childs').trigger('change');

</script>
@endpush
