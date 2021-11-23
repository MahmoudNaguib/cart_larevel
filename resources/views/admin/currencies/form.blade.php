@foreach(langs() as $lang)
    @include('form.input',['name'=>'title['.$lang.']','value'=>$row->getTranslation('title',$lang),'type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Title').' '.$lang,'placeholder'=>trans('app.Title'),'required'=>1]])
@endforeach
@include('form.input',['name'=>'iso','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.ISO'),'placeholder'=>trans('app.ISO'),'required'=>1]])

@include('form.input',['name'=>'rate','type'=>'number','attributes'=>['class'=>'form-control','label'=>trans('app.Rate'),'placeholder'=>trans('app.Rate'),'step'=>'0.01','required'=>1,'min'=>0,'pattern'=>'^\d*(\.\d{0,3})?$']])
