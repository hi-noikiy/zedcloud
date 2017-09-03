@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <ol class="breadcrumb">           
            <li class="active"><i class="fa fa-edit"></i> <span>用户的预约商品</span></li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('user::user.name')</th>
                <th>@lang('user::user.phone')</th>
                <th>@lang('user::user.sex')</th>
                <th>@lang('user::user.head')</th>   
                 <th>预约的商品</th> 
                  <th>商品价格</th> 
                 <th>订单状态</th> 
                <th>操作</th>

                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $k=>$user)
            <tr>
                    
                    <td>{{$k + 1}}</td>
                    <td>{{$user->nickname}}</td>
                    <td>{{$user->phone}}</td>
                    <td>@if($user->sex ==1)男@else女@endif</td>
                    <td><img class="img_show" style="width: 50px;height:50px;" name="{{$user->headimg}}" src="{{$user->headimg}}"></td>
               <td>{{$user->pname}}</td>
               <td>{{$user->price}}</td>
               <td>@if($user->status ==0)<span style="color:red">未沟通</span>@else已沟通@endif</td>
                <td>
                    @if($user->status ==0)<a href="{{route('user.deal',['uid'=>$user->user_id,'pid'=>$user->product_id])}}" class= "btn btn-xs btn-success">已沟通</a>@endif
                </td>

                
            </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pull-right">
           @if($users){{$users->links()}}@endif
        </div>
    </div>
@endsection