
@include('form.input',['name'=>'code','type'=>'text','attributes'=>['class'=>'form-control','label'=>trans('app.Code'),'placeholder'=>trans('app.Code'),'text'=>trans('app.If code not set it will be generated')]])

@include('form.select',['name'=>'currency_id','options'=>$row->getCurrencies(),'attributes'=>['class'=>'form-control','label'=>trans('app.Currency'),'placeholder'=>trans('app.Currency'),'required'=>1]])

@include('form.input',['name'=>'amount','type'=>'number','attributes'=>['class'=>'form-control','label'=>trans('app.Value'),'placeholder'=>trans('app.Amount'),'step'=>'0.01','required'=>1,'min'=>0,'pattern'=>'^\d*(\.\d{0,3})?$']])


@include('form.input',['name'=>'expiry_date','type'=>'text','attributes'=>['class'=>'form-control datepicker','label'=>trans('app.Expiry date'),'placeholder'=>trans('app.Expiry date')]])

@include('form.input',['name'=>'max_usage','type'=>'number','attributes'=>['class'=>'form-control','label'=>trans('app.Max Usage'),'placeholder'=>trans('app.Max Usage'),'step'=>'1','required'=>1,'min'=>0]])
