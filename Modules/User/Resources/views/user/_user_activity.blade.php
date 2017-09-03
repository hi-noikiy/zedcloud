@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>已报名</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
             <li><a href="JavaScript:history.go(-1);"><i class="fa fa-home"></i> 用户列表</a></li>
            <li class="active"><i class="fa fa-edit"></i> 用户已报名</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>@lang('user::user.name')</th>
                <th>@lang('user::user.phone')</th>
                <th>@lang('user::user.sex')</th>
                <th>@lang('user::user.head')</th>                

            
            </tr>
            </thead>
            <tbody>
            <tr>                   
                    <td>{{$users->username}}</td>
                    <td>{{$users->phone}}</td>
                    <td>@if($users->sex == 1)男@else女@endif</td>
                    <td><img style="width: 50px;height:50px;" src="{{$users->wx_headimgurl}}"></td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <hr>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>活动名称</th>
                <th>活动价格</th>
                <th>原价格</th>
                <th>报名时间</th>                   

            </tr>
            </thead>
            <tbody>
            @foreach($activities as $k=>$activity)
            <tr>     
                    <td>{{$k+1}}</td>              
                    <td>{{$activity->name}}</td>
                    <td>{{$activity->new_price}}</td>
                    <td>{{$activity->before_price}}</td>
                    <td>{{$activity->created_at}}</td>                                  
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    
    
    
@endsection