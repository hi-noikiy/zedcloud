@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>活动</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li class="active"><i class="fa fa-edit"></i> 活动列表</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
 <div class="table-responsive">

        <a href="{{ route('activity.activity.create') }}" class="pull-right btn btn-success">新增活动</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>活动编号</th>
                <th>活动名称</th>
                <th>原价</th>
                <th>现价</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>活动状态</th>
                <th>活动封面</th>
                <th>是否热推</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
           @foreach($activities as $key=>$activity)
                <tr>
                    <td>{{ $key + 1 }}</td>
                     <td>{{ $activity->_id }}</td>
                    <td>{{ $activity->name }}</td>                 
                    <td>{{ $activity->before_price }}</td>
                    <td>{{ $activity->new_price }}</td>
                    <td>{{ $activity->start_time }}</td>
                    <td>{{ $activity->end_time }}</td>
                    <td>@if($activity->status == 0 )未开始@elseif($activity->status == 1)进行中@else已结束@endif</td>
                     <td><img src="{{ $activity->cover }}" style="width:50px;height:50px;"></td>
                    <td>@if($activity->hot == 0 )否@else是@endif</td>
                    
                    <td>
                         <a href="{{ route('activity.activity.edit',['_activity_id'=>$activity->_id]) }}" class="btn btn-warning ">编辑</a>
                         <a href="{{ route('activity.activity.destroy',['_activity_id'=>$activity->_id]) }}" class="btn btn-danger btn-delete">删除</a>
                         
                         @if($activity->hot)
                            <a href="{{ route('activity.activity.unsethot', ['_activity_id' => $activity->_id]) }}" class="btn  btn-warning">取消热推</a>
                        @else
                            <a href="{{ route('activity.activity.sethot', ['_activity_id' => $activity->_id]) }}" class="btn  btn-warning">设成热推</a>
                        @endif
                    </td>
                </tr>
            @endforeach 
            </tbody>
        </table>

        <div class="pull-right">
            {{ $activities->links() }} 
        </div>








@endsection