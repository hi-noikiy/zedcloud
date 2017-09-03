@extends('layouts.app')


@section('breadcrumb')


    <div class="row page-header">
        <ol class="breadcrumb">          
            <li><a href="{{ route('album.album.list') }}"> <i class="fa fa-home"></i><span>相册</span></a></li>
        </ol>
        <a data-toggle="modal" data-target="#mymodal"  class=" btn pull-right btn-success">新建相册</a>
    </div><!-- /.row -->
@endsection

@section('content')
 <style>
        .pics{
	       width:100%;
        }
        .pics .sub{
	      width:22% ;
        	height:340px;
        	margin-left:2%;  
        	border:1px solid #ccc;
        	float:left;
        	background:#fff;
        	border-radius:10px;
        	margin-top:20px;
        	
        	
        }
        .pics .sub .imgs{
	      width:90% ;
        	margin:0 auto;
        	margin-top:10px;
        	height:180px;
        }
        .pics .sub .imgs img{
	       width:100% ;
        	height:100%;
        }
        .content{
	     width:90% ; 
           height:30px;
           margin:0 auto; 
           margin-top:5px;
           border-bottom:1px solid #ccc;
           line-height:30px;
        }
        
        
</style>

 
 
 
<div class="pics">
@foreach($albums as $key=>$album)
             
            
    <div class="sub">
         <div class="imgs">
          <a href="{{ route('album.photo.list', ['_album_id' => $album->_id]) }}">
            <img  src="{{ $album->cover }}">
            </a>
         </div>
         <div class="content">
            <span>相册名称  :  {{ $album->name }}</span>
         </div>
         <div class="content">
            <span>图片数量 :  {{ $album->photo_number }} / 张</span>  
         </div>
         <div class="content">
            <span>首页展示 :  @if($album->hot)<span style="color:#00f">是</span>@else<span style="color:red">否</span>@endif</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
         </div>
         <div class="content">
         @if($album->hot)
                            <a href="{{ route('album.album.unsethot', ['_album_id' => $album->_id]) }}" class="btn btn-xs   btn-success">取消展示</a>
                        @else
                            <a href="{{ route('album.album.sethot', ['_album_id' => $album->_id]) }}" class="btn btn-xs  btn-success">首页展示</a>
                        @endif

                        <a id="{{$album->_id}}" name="{{ route('album.album.update', ['_album_id' => $album->_id]) }}" onclick="javascript:model_edit('{{$album->_id}}','{{$album->name}}','{{$album->like}}');" class="btn btn-xs btn-success ">编辑</a> 
                        <a href="{{ route('album.album.destroy', ['_album_id' => $album->_id]) }}" class="btn btn-xs btn-success  btn-delete">删除</a>
                  
         </div>
    </div>
    
    @endforeach

</div>

 
    
  <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					新增相册
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{  route('album.album.store')  }}" enctype="multipart/form-data">
			<div class="modal-body">
		            {{ csrf_field() }}
		
		        <input type="hidden" name="_category_id" value="0">

	            <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
	                <label class="col-sm-2 control-label">相册封面</label>
	                <div class="col-sm-10">
	                    <input type="file" class="form-control" name="cover">
	                    @if ($errors->has('cover'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('cover') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	
	            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
	                <label class="col-sm-2 control-label">相册名称</label>
	                <div class="col-sm-10">
	                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
	                    @if ($errors->has('name'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('name') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	
	            <div class="form-group {{ $errors->has('like') ? 'has-error' : '' }}">
	                <!-- <label class="col-sm-2 control-label">@lang('album::album.like')</label> -->
	                <div class="col-sm-10">
	                    <input type="hidden" value="0" class="form-control" name="like" value="{{ old('like') }}">
	                    @if ($errors->has('like'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('like') }}</strong>
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




<div class="modal fade" id="mymodal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					编辑
				</h4>
			</div>
			 <form class="form-horizontal" id="edit_form" method="post" action="" enctype="multipart/form-data">
			<div class="modal-body">
		            {{ csrf_field() }}
		            {{ method_field('PUT') }}
		
		            <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
		                <label class="col-sm-2 control-label">相册封面</label>
		                <div class="col-sm-10">
		                    <input type="file" class="form-control" name="cover" value="">
		                    @if ($errors->has('cover'))
		                        <span class="help-block">
		                        <strong>{{ $errors->first('cover') }}</strong>
		                    </span>
		                    @endif
		                </div>
		            </div>
		
		            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
		                <label class="col-sm-2 control-label">相册名称</label>
		                <div class="col-sm-10">
		                    <input type="text" id="album_name" class="form-control" name="name" value="">
		                    @if ($errors->has('name'))
		                        <span class="help-block">
		                        <strong>{{ $errors->first('name') }}</strong>
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



<script>


	function model_edit(id,name,like)
	{		
		var url = $('#'+id).attr('name');
		$('#edit_form').attr('action',url);
		$('#album_name').val(name);
		$('#album_like').val(like);
		$('#mymodal_edit').modal('show');
		return false;		
	}
</script>
@endsection

