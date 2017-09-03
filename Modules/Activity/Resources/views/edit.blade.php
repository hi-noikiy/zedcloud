@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>活动创建</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('activity.activity.list') }}"><i class="fa fa-home"></i> 活动列表</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.edit')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker.css') }}"/ >

<script src="{{asset('js/datetimepicker.js')}}"></script>


    <div class="table-responsive">
        <form class="form-horizontal" method="post" action="{{ route('activity.activity.update') }}" enctype="multipart/form-data">
            <input type="hidden" value="{{$activity->_id}}" name="_id">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">活动名称</label>
                <div class="col-sm-10">
                    <input required type="text" value="{{$activity->name}}" class="form-control" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
             <div class="form-group {{ $errors->has('combo_id') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">关联套系编号</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$activity->combo_id}}" class="form-control" name="combo_id" value="{{ old('combo_id') }}">
                    @if ($errors->has('combo_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('combo_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group {{ $errors->has('before_price') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">原价</label>
                <div class="col-sm-10">
                    <input required type="text" value="{{$activity->before_price}}"  class="form-control" name="before_price" value="{{ old('before_price') }}">
                    @if ($errors->has('before_price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('before_price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group {{ $errors->has('new_price') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">现价</label>
                <div class="col-sm-10">
                    <input required type="text"  value="{{$activity->new_price}}" class="form-control" name="new_price" value="{{ old('new_price') }}">
                    @if ($errors->has('new_price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">活动地点</label>
                <div class="col-sm-10">
                    <input required type="text" value="{{$activity->address}}" class="form-control" name="address" value="{{ old('address') }}">
                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">活动开始时间</label>
                <div class="col-sm-10">
                    <input required type="text" value="{{$activity->start_time}}" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}">
                    @if ($errors->has('start_time'))
                        <span class="help-block">
                            <strong>{{ $errors->first('start_time') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">活动结束时间</label>
                <div class="col-sm-10">
                    <input required value="{{$activity->end_time}}" type=text class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}">
                    @if ($errors->has('end_time'))
                        <span class="help-block">
                            <strong>{{ $errors->first('end_time') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
           <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">活动封面</label>
                <div class="col-sm-10">
                    <input  type="file" class="form-control" name="cover" value="{{ old('cover') }}">
                    @if ($errors->has('cover'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cover') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
             <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">活动详情</label>  
                              
            </div>
        
           <script src="{!!asset('/laravel-u-editor/ueditor.config.js')!!}"></script>
           <script src="{!!asset('/laravel-u-editor/ueditor.all.min.js')!!}"></script>
           <script style="width: 90%;height:500px;margin-left:200px;" id="container" name="content" type="text/plain"></script>
           <script type="text/javascript">
              
               
               
               var ue = UE.getEditor('container'); 
               ue.ready(function() { 
            	   ue.setContent($('#ht').val());          	   
            	   });
           </script>
            <input  value="{{$activity->detail}}" type="hidden"  id="ht" >
            <br>
            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-10">
                    <button type="submit" class="btn center btn-success">@lang('main.submit')</button>
                </div>
            </div>

        </form>
    </div>
    
    
    <script>
$('#start_time').datetimepicker();
$('#end_time').datetimepicker();
</script>
@endsection