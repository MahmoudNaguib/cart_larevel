@include('form.select',['name'=>'top_id','options'=>$row->getMainCategories(),'attributes'=>['class'=>'form-control','label'=>trans('app.Parent category'),'placeholder'=>trans('app.Parent category')]])

@foreach(langs() as $lang)
    @include('form.input',['name'=>'title['.$lang.']','value'=>$row->getTranslation('title',$lang),'type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Title').' '.$lang,'placeholder'=>trans('app.Title'),'required'=>1]])
@endforeach


@include('form.file',['name'=>'image','attributes'=>['class'=>'form-control custom-file-input','label'=>trans('app.Image'),'placeholder'=>trans('app.Image')]])


@include('form.boolean',['name'=>'is_active','attributes'=>['label'=>trans('app.Is active')]])
