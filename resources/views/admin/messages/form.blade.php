
@include('form.input',['name'=>'name','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Name'),'placeholder'=>trans('app.Name'),'required'=>1]])
@include('form.input',['name'=>'email','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Email'),'placeholder'=>trans('app.Email'),'required'=>1]])
@include('form.input',['name'=>'content','type'=>'textarea','attributes'=>['class'=>'form-control editor','label'=>trans('app.Content'),'placeholder'=>trans('app.Content'),'required'=>1]])
