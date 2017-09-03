@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>已预约</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="JavaScript:history.go(-1);"><i class="fa fa-home"></i> 用户列表</a></li>
            <li class="active"><i class="fa fa-edit"></i> 用户预约详情</li>
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
                <th>@lang('user::user.combo')</th>
                <th>@lang('user::user.price')</th>
                <th>@lang('user::user.apply_time')</th>              

            </tr>
            </thead>
            <tbody>
            @foreach($combos as $k=>$combo)
            <tr>     
                    <td>{{$k+1}}</td>              
                    <td>{{$combo->name}}</td>
                    <td>{{$combo->price}}</td>
                    <td>{{$combo->apply_time}}</td>                                  
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    
    
    
@endsection