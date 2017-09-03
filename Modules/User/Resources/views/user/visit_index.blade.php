@extends('layouts.app')
@section('breadcrumb')
    <div class="row page-header">

        <ol class="breadcrumb">    
            <li class="active"><i class="fa fa-edit"></i><span>小程序用户</span></li>
        </ol>
    </div><!-- /.row -->
@endsection
@section('content')
<h2>平台用户总数 ： {{$total}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;今日访问人数 ： {{$today}} </h2>
<hr>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>头像</th>
                <th>微信昵称</th>
                <th>性别</th>
                <th>手机号</th>
                <th>最近一次访问时间</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach($users as $k=>$user)
            <tr>     
                    <td>{{$k+1}}</td>      
                     <td><img style="width: 50px;height:50px;" class="img_show" name="{{$user->headimg}}?imageMogr2/auto-orient/thumbnail/200x200/blur/1x0/quality/75|imageslim" src="{{$user->headimg}}?imageMogr2/auto-orient/thumbnail/200x200/blur/1x0/quality/75|imageslim"></td>        
                    <td>{{$user->nickname}}</td>
                    <td>@if($user->sex == 1)男@else女@endif</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->update_at}}</td>                               
            </tr>
            @endforeach
            
            </tbody>
        </table>
    </div>
    <div class="foot">
        {!!$users->links()!!}
    </div>
@endsection