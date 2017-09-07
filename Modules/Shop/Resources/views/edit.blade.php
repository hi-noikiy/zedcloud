@extends('layouts.app')
@section('breadcrumb')
    <div class="row page-header">
        <ol class="breadcrumb">       
            <li class="active"><i class="fa fa-edit"></i><span> 门店管理 / 编辑门店</span></li>
        </ol>
    </div><!-- /.row -->
@endsection
@section('content')
<style>
   .form-group{
	position:relative;
   	left:200px;
   }
</style>
<script src="{{asset('js/jscolor.js')}}"></script>
<form class="form-horizontal" method="post" action="{{ route('shop.shop.update') }}" enctype="multipart/form-data">
{{ csrf_field() }}

 
            
            
            <div class="row">
		  <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                <label class="col-sm-1 ">店面照片</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control"   name="cover">
                    @if ($errors->has('cover'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cover') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
		</div>
		<hr> 
		<div class="row">
		  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
		     <label class="col-sm-1">门店名称</label>
		     <div class="col-sm-6">
			     <input  value="{{ $company->name }}" type="text" id="name" class="form-control" name="name">
			     @if ($errors->has('name'))
			     <span class="help-block">
			     <strong>{{ $errors->first('name') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		</div>
		<hr> 

		<div class="row">
		  <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
		     <label class="col-sm-1">联系电话</label>
		     <div class="col-sm-6">
			     <input required value="{{ $company->telephone }}" type="text" id="phone" class="form-control" name="phone">
			     @if ($errors->has('phone'))
			     <span class="help-block">
			     <strong>{{ $errors->first('phone') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		</div>
		<hr> 
		<div class="row">
		  <div class="form-group {{ $errors->has('addr') ? 'has-error' : '' }}">
		     <label class="col-sm-1">商家地址</label>
		     <div class="col-sm-6">
			     <input required value="{{ $company->address }}" type="text" id="addr" class="form-control" name="addr">
			     @if ($errors->has('addr'))
			     <span class="help-block">
			     <strong>{{ $errors->first('addr') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		</div>
		<hr> 
		<div class="row">
		  <div class="form-group {{ $errors->has('latitude') ? 'has-error' : '' }}">
		     <label class="col-sm-1">地址经度</label>
		     <div class="col-sm-6">
			     <input required value="{{ $company->latitude }}" type="text" id="latitude" class="form-control" name="latitude">
			     @if ($errors->has('latitude'))
			     <span class="help-block">
			     <strong>{{ $errors->first('latitude') }}</strong>
			     </span>
			     @endif
		     </div>
		     <a target="_blank" class="btn btn-warning" href="http://lbs.qq.com/tool/getpoint/index.html">去获取经纬度</a>
		  </div>
		</div>
		<hr> 
		<div class="row">
		  <div class="form-group {{ $errors->has('longitude') ? 'has-error' : '' }}">
		     <label class="col-sm-1">地址纬度</label>
		     <div class="col-sm-6">
			     <input required value="{{ $company->longitude }}" type="text" id="longitude" class="form-control" name="longitude">
			     @if ($errors->has('longitude'))
			     <span class="help-block">
			     <strong>{{ $errors->first('longitude') }}</strong>
			     </span>
			     @endif
			     
		     </div>
		  </div>
		</div>
		<hr> 
		
	
		
		<div class="row">
		  <div class="form-group {{ $errors->has('appid') ? 'has-error' : '' }}">
		     <label class="col-sm-1">app_id</label>
		     <div class="col-sm-6">
			     <input required value="{{$company->appid}}" type="text" id="appid" class="form-control" name="appid">
			     @if ($errors->has('appid'))
			     <span class="help-block">
			     <strong>{{ $errors->first('appid') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		</div>
		<hr>
		<div class="row">
		  <div class="form-group {{ $errors->has('appsecret') ? 'has-error' : '' }}">
		     <label class="col-sm-1">app_secret</label>
		     <div class="col-sm-6">
			     <input required value="{{$company->appsecret}}" type="text" id="appsecret" class="form-control" name="appsecret">
			     @if ($errors->has('appsecret'))
			     <span class="help-block">
			     <strong>{{ $errors->first('appsecret') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		</div>
		<hr>
		
		<div class="row">
		  <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
		     <label class="col-sm-1">账号</label>
		     <div class="col-sm-6">
			     <input required value="@if($user){{$user->username}}@endif" type="text" id="username" class="form-control" name="username">
			     @if ($errors->has('appid'))
			     <span class="help-block">
			     <strong>{{ $errors->first('appid') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		</div>
		<hr>
		<div class="row">
		  <div class="form-group {{ $errors->has('adminkey') ? 'has-error' : '' }}">
		     <label class="col-sm-1">adminkey</label>
		     <div class="col-sm-6">
			     <input required value="@if($user){{$user->key}}@endif" type="text" id="adminkey" class="form-control" name="adminkey">
			     @if ($errors->has('adminkey'))
			     <span class="help-block">
			     <strong>{{ $errors->first('adminkey') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		</div>
		<hr>
		
 <input required value="{{ $company->id }}" type="hidden" id="com_id" class="form-control" name="com_id">
	 <input required value="@if($user){{ $user->id }}@endif" type="hidden" id="user_id" class="form-control" name="user_id">
		<input type="submit" style="margin-left: 400px;" class="col-sm-1 btn btn-success pull-center" value="提交">
		
</form>
    
@endsection