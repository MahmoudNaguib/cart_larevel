@extends('layouts.admin')
@section('title')
<h6 class="slim-pagetitle">
    {{ @$page_title }}
</h6>
@endsection
@section('content')
<div class="section-wrapper">
    @if(can('view-'.$module))
        @if($rows)
        <div class="table-responsive">
            <table class="table display responsive nowrap">
                <thead>
                    <tr>
                        <th class="wd-5p">{{trans('app.ID')}} </th>
                        <th class="wd-15p">{{trans('app.File name')}} </th>
                        <th class="wd-15p">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                        @foreach ($rows as $row)
                        <tr>
                            <td class="center">{{$i}}</td>
                            <td class="center">{{ucfirst($row)}}</td>
                            <td class="center">
                                @if(can('edit-'.$module))
                                <a class="btn btn-success btn-xs" href="{{lang()}}/admin/{{$module}}/edit/{{$row}}" title="{{trans('app.Edit')}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    @endif
</div>
@endsection
