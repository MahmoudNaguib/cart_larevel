@foreach(langs() as $lang)
@php
$attributes=['class'=>'form-control','label'=>trans('app.Title').' '.$lang,'placeholder'=>trans('app.Title')];
if($lang=='en')
$attributes['required']=1;
@endphp
@include('form.input',['name'=>'title['.$lang.']','value'=>$row->getTranslation('title',$lang),'type'=>'text','attributes'=>$attributes])
@endforeach



@foreach(langs() as $lang)
@php
$attributes=['class'=>'form-control editor','label'=>trans('app.Content').' '.$lang,'placeholder'=>trans('app.Content')];
if($lang=='en')
$attributes['required']=1;
@endphp
@include('form.input',['name'=>'content['.$lang.']','value'=>$row->getTranslation('content',$lang),'type'=>'textarea','attributes'=>$attributes])
@endforeach


@include('form.input',['name'=>'url','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.URL'),'placeholder'=>trans('app.URL'),'required'=>1]])

@include('form.file',['name'=>'image','attributes'=>['class'=>'form-control custom-file-input','label'=>trans('app.Image'),'placeholder'=>trans('app.Image')]])

@include('form.boolean',['name'=>'is_active','attributes'=>['label'=>trans('app.Is active')]])


@push('js')
<script>
    $(function () {
    $('form').submit(function () {
    var title_en = $('input[name="title[en]"]').val();
            @foreach(langs() as $lang)
            if ($('input[name="title[{{$lang}}]"]').val() == '')
            $('input[name="title[{{$lang}}]"]').val(title_en);
            @endforeach

            var content_en = $('textarea[name="content[en]"]').val();
            @foreach(langs() as $lang)
            if ($('textarea[name="content[{{$lang}}]"]').val() == '')
            $('textarea[name="content[{{$lang}}]"]').val(content_en);
            @endforeach
    });
    });
</script>
@endpush
