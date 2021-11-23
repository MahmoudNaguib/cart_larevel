<div class="row">
    <div class="col-md-3 mb-3">
        <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
            @foreach($rows as $key=>$value)
            <li class="nav-item">
                <a class="nav-link {{($loop->first)?'active':''}}" id="tab_{{$loop->index}}" data-toggle="tab" href="#item_{{$loop->index}}" role="tab" aria-controls="home" aria-selected="true">{{trans('configs.'.$key)}}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-9">
        <div class="tab-content" id="myTabContent">
            @foreach($rows as $key=>$value)
            <div class="tab-pane fade show {{($loop->first)?'active':''}}" id="item_{{$loop->index}}" role="tabpanel" aria-labelledby="home-tab">
                <h2>{{trans('configs.'.$key)}}</h2>
                <p>
                    @foreach($value as $row)
                    @php
                    $label=trans('configs.'.$row->label);
                    if($row->lang)
                    $label.=' ('.languages()[$row->lang].')';
                    @endphp
                    @if($row->field_type=='file')
                    @include('form.file',['name'=>'input_'.$row->id,'attributes'=>['class'=>'form-control custom-file-input','label'=>$label,'value'=>$row->value]])
                    @else

                    @include('form.input',['type'=>$row->field_type,'name'=>'input_'.$row->id,'value'=>$row->value,'attributes'=>['class'=>'form-control '.$row->field_class,'label'=>$label.' ',$row->field]])
                    @endif
                    @endforeach
                </p>
            </div>
            @endforeach

        </div>
    </div>
    <!-- /.col-md-8 -->
</div>
<!-- /.container -->

