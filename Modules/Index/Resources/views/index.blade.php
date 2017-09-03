@extends('layouts.app')

@section('breadcrumb')

    <div class="row page-header">
        <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-home"></i> <span>首页</span></a></li>           
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
<script src="{!!asset('/laravel-u-editor/ueditor.config.js')!!}"></script>
<script src="{!!asset('/laravel-u-editor/ueditor.all.min.js')!!}"></script>
<style>
    .runbo{
	width:100%;
    	height:300px;
    	background:#fff;
    	border-radius:10px;
    	border:2px solid #aaa;
    	margin-top:50px;
    }
    .runbo .head{
	width:100%;
    	height:50px; 
    	text-align:center;
    	font-size:20px;
    	font-weight:900;
    	color:blue;
    }
    .runbo .sub{
	width:30%;
    	height:230px;
      margin-left:3%; 
    	float:left;
    	
    }
    .runbo .sub .imgs{
	width:90%;
    	height:200px;
    	position:relative;
    	
    	margin:0 auto;
    	margin-top:10px;
    }
    .sub .imgs img{
	width:100%;
    	height:100%;
    }
    .imgs .del{
	position:absolute;
    	top:0px;
    	text-align:center;
    }
    
    .notice{
	width:100%;
    	height:110px;
    	background:#fff;
    	border-radius:10px;
    	border:2px solid #aaa;
    	margin-top:50px;
    }
.notice .head{
	width:100%;
    	height:50px; 
    	text-align:center;
    	font-size:20px;
    	font-weight:900;
	color:blue;
    	
    }
    .notice .content{
	width:90%;
    	margin:0 auto;
    	
    }
    .sub2{
    	margin-top:20px;
	width:40%;
    	border:1px solid #aaa;
    	height:200px;
    	float:left;
    	margin-left:5%;
    }
    .imgs2{
	width:100%;
    	height:200px;
    }
    .imgs2 img{
	width:100%;
    	height:100%;
    }

</style>
<div style="margin-top:100px;">
	<a data-toggle="modal" data-target="#myModal"  class="pull-right btn btn-success">上传轮播图片</a>
</div>
<div class="runbo">
    <div class="head">
        <span>轮播图</span>
    </div>
    @foreach($lunbos as $k=>$v)
    <div class="sub">
        <div class="imgs">
            <img class="img_show" name="{{env('APP_CDN').$v->imgurl}}" src="{{env('APP_CDN').$v->imgurl}}?imageMogr2/auto-orient/thumbnail/300x300/blur/1x0/quality/75|imageslim">
            <div class="del"><a  href="{{ route('index.lunbo.remove', ['_lunbo_id' => $v->_id]) }}" class=" btn-delete btn  btn-xs btn-warning">删除</a></div>
        </div>
        
    </div>
    @endforeach
</div>


<div style="margin-top:100px;">
	<a data-toggle="modal" data-target="#myModal2"  class="pull-right btn btn-success">发布新公告</a>
</div>
<div class="notice">
    <div class="head">
        <span>门店公告</span>
    </div>
    <div class="content">
        <span>{{$company->notice}}</span>
    </div>
</div>

<div style="margin-top:100px;">
	<a data-toggle="modal" data-target="#myModal3"  class="pull-right btn btn-success">修改关于我们</a>
</div>
<div class="runbo">
    <div class="head">
        <span>关于我们</span>
    </div>

    <div class="sub2">
        
        <div class="imgs2">
            
            <img class="img_show" name="{{env('APP_CDN')}}{{$company->logo}}" src="{{env('APP_CDN')}}{{$company->logo}}?imageMogr2/auto-orient/thumbnail/300x300/blur/1x0/quality/75|imageslim">
             <span>门店图片</span>
        </div>
        
    </div>
    <div class="sub2">
        <br>门店介绍:<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$company->shop_introduce}}
    </div>
 
</div>



   
 <!--   
        <br>
        <div class="row">
		<h3 class="modal-title" id="myModalLabel">
			关于我们
		</h3>
		<br>
		 <form class="form-horizontal" method="post" action="{{ route('index.us.create') }}" enctype="multipart/form-data">

                {{ csrf_field() }}        
                
                <script style="width: 100%;height:500px;" id="container" name="content" type="text/plain"></script>
                <script type="text/javascript">                                           
                   var ue = UE.getEditor('container'); 
                   ue.ready(function() { 
                	   ue.setContent($('#ht').val());          	   
                	   });
                </script>
                <input  value="@if($us){{$us->content}}@endif" type="hidden"  id="ht" >
			 <button type="submit" class=" btn btn-primary">保存</button>     		
		</form>


    </div>
 -->     
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					上传轮播图
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('index.lunbo.create') }}" enctype="multipart/form-data">
			<div class="modal-body">
    	       
                    {{ csrf_field() }}        
                    <div class="form-group {{ $errors->has('lunbo') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">轮播图</label>
                        <div class="col-sm-8">
                            <input type="file" id="lunbo" class="form-control" name="lunbo">
                            @if ($errors->has('lunbo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lunbo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                  
			</div>
			<div class="modal-footer">
				 <button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
				    <button type="submit" class=" btn btn-primary">确认上传</button>     
			</div>
			</form>
		</div>
	</div>
</div>

 <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					编辑关于我们
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('index.about.create') }}" enctype="multipart/form-data">
			<div class="modal-body">
    	       
                    {{ csrf_field() }}        
                    <div class="form-group {{ $errors->has('shop') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">门店图片</label>
                        <div class="col-sm-8">
                            <input type="file" id="shop" class="form-control" name="shop">
                            @if ($errors->has('shop'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('shop') }}</strong>
                                </span>
                            @endif
                        </div>
                        <br>
                        <br>
                        <label class="col-sm-2 control-label">门店介绍</label>
                        <div class="col-sm-8">
                            
                            <input type="text" id="introduce" class="form-control" name="introduce" value="{{$company->shop_introduce}}">
                            @if ($errors->has('"introduce"'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('"introduce"') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        
                    </div> 
                  
			</div>
			<div class="modal-footer">
				 <button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
				    <button type="submit" class=" btn btn-primary">确认</button>     
			</div>
			</form>
		</div>
	</div>
</div>




    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					发布新公告
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('index.notice.create') }}" >
			<div class="modal-body">
    	       
                    {{ csrf_field() }}        
                    <div class="form-group {{ $errors->has('lunbo') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">公告内容</label>
                        <div class="col-sm-8">
                            <input type="text" id="notice" class="form-control" name="notice" required>
                            @if ($errors->has('"notice"'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('"notice"') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                  
			</div>
			<div class="modal-footer">
				 <button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
				    <button type="submit" class=" btn btn-primary">确认发布</button>     
			</div>
			</form>
		</div>
	</div>
</div>


    


    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					编辑关于
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('index.us.edit') }}" enctype="multipart/form-data">
			<div class="modal-body">
    	       
                    {{ csrf_field() }}        
                    
                
			</div>
			<div class="modal-footer">
				 <button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
				    <button type="submit" class=" btn btn-primary">保存</button>     
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<script>
function modelshow(_id,link,link_type)
{
    $('#type_id').val(link_type);	
    $('#link_id').val(link);
    $('#_id').val(_id);
    $('#myModal_edit').modal('show');
}
</script>
<div class="modal fade" id="myModal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					编辑轮播图
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('index.lunbo.update') }}" enctype="multipart/form-data">
			<div class="modal-body">
    	        <input type="hidden" id="_id" name="_lunbo_id" >
                    {{ csrf_field() }}        
                    <div class="form-group {{ $errors->has('lunbo') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">轮播图</label>
                        <div class="col-sm-8">
                            <input type="file" id="lunbo" class="form-control" name="lunbo">
                            @if ($errors->has('lunbo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lunbo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">跳转类型</label>
                        <div class="col-sm-8">
                            <select id="type_id" name="link_type" class="form-control" requied>
                                <option value="1">套系</option>
                                <option value="2">活动</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">跳转编号</label>
                        <div class="col-sm-8">
                            <input id="link_id" type="text" id="url" class="form-control" name="url">
                            @if ($errors->has('url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                             
                
			</div>
			<div class="modal-footer">
				 <button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
				    <button type="submit" class=" btn btn-primary">保存</button>     
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

    <div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					添加礼包
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('index.gift.create') }}" enctype="multipart/form-data">
			<div class="modal-body">
    	       
                    {{ csrf_field() }}        
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">礼包名称</label>
                        <div class="col-sm-8">
                            <input required type="text" id="name" class="form-control" name="name">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">礼包价格</label>
                        <div class="col-sm-8">
                            <input required type="number" id="price" class="form-control" name="price">
                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group {{ $errors->has('intro') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">礼包简介</label>
                        <div class="col-sm-8">
                            <input required type="text" id="intro" class="form-control" name="intro">
                            @if ($errors->has('intro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('intro') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">礼包详情</label>                        
                    </div> 
                   
	                <script style="width: 100%;height:300px;" id="container2" name="content2" type="text/plain"></script>
	                <script type="text/javascript">                                           
	                   var ue2 = UE.getEditor('container2'); 
	                </script>
       
			</div>
			<div class="modal-footer">
				 <button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
				    <button type="submit" class=" btn btn-primary">保存</button>     
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

  

@endsection