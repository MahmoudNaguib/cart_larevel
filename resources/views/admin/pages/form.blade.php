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
@include('form.file',['name'=>'image','attributes'=>['class'=>'form-control custom-file-input','label'=>trans('app.Image'),'placeholder'=>trans('app.Image')]])

@include('form.boolean',['name'=>'is_active','attributes'=>['label'=>trans('app.Is active')]])


<h3><u>{{trans('app.Search engine optmization')}}(SEO)</u></h3>
@foreach(langs() as $lang)
@include('form.input',['name'=>'meta_description['.$lang.']','value'=>$row->getTranslation('meta_description',$lang),'type'=>'textarea','attributes'=>['class'=>'form-control','label'=>trans('app.Meta description').' '.$lang,'placeholder'=>trans('app.Meta description')]])
@endforeach

@foreach(langs() as $lang)
@include('form.input',['name'=>'meta_keywords['.$lang.']','value'=>$row->getTranslation('meta_keywords',$lang),'type'=>'text','attributes'=>['class'=>'form-control tags','label'=>trans('app.Meta keywords').' '.$lang,'placeholder'=>trans('app.Meta keywords')]])
@endforeach


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

            var meta_description_en = $('textarea[name="meta_description[en]"]').val();
            @foreach(langs() as $lang)
            if ($('textarea[name="meta_description[{{$lang}}]"]').val() == '')
            $('textarea[name="meta_description[{{$lang}}]"]').val(meta_description_en);
            @endforeach

            var meta_keywords_en = $('input[name="meta_keywords[en]"]').val();
            @foreach(langs() as $lang)
            if ($('input[name="meta_keywords[{{$lang}}]"]').val() == '')
            $('input[name="meta_keywords[{{$lang}}]"]').val(meta_keywords_en);
            @endforeach


    });
    });
</script>
@endpush
