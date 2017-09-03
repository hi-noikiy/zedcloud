@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>已收藏</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="JavaScript:history.go(-1);"><i class="fa fa-home"></i> 用户列表</a></li>
            <li class="active"><i class="fa fa-edit"></i> 用户已收藏</li>
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
                <th>名称</th>
                <th>类型</th>
                <th>价格</th>
                <th>收藏时间</th>              

            </tr>
            </thead>
            <tbody>
            @foreach($collets as $k=>$collet)
            <tr>     
                    <td>{{$k+1}}</td>              
                    <td>{{$collet->name}}</td>
                    <td>{{$collet->type}}</td>
                    <td>{{$collet->price}}</td>
                    <td>{{$collet->created_at}}</td>                                  
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    
    
    
@endsection