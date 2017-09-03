@extends('layouts.app')

@section('breadcrumb')

    <div class="row page-header">
        <ol class="breadcrumb">          
            <li><a href="{{ route('album.album.list') }}"> <i class="fa fa-home"></i><span> 相册</span></a></li>
            <li class="active"><i class="fa fa-edit"></i> <span>{{$album->name}}</span></li>
        </ol>
        <a data-toggle="modal" data-target="#myModal"  class="pull-right btn btn-success">上传图片</a>
    </div><!-- /.row -->
    
@endsection

@section('content')
<style>
        .pics{
	       width:100%;
        }
        .pics .sub{
	      width:18% ;
        	height:200px;
        	margin-left:2%;  
        	border:1px solid #ccc;
        	float:left;
        	background:#fff;
        	border-radius:10px;
        	margin-top:20px;
        	position:relative;
        	
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
        .s-delete{
	       
        	position:absolute;
        	top:10px;
        	right:10px;
        }

        
        
</style>

 
        
        
<div class="pics">
@foreach($photos as $key=>$photo)
  
        <div class="sub">
       
            <div class="imgs">
                  <img class="img_show" name="{{$photo->url}}"  src="{{$photo->url}}?imageMogr2/auto-orient/thumbnail/250x250/blur/1x0/quality/75|imageslim">
            </div>
            <div class="s-delete">
                <a href="{{ route('album.photo.destroy', ['_photo_id' => $photo->_id]) }}" class="btn btn-danger btn-xs  btn-delete">@lang('main.destroy')</a>
            </div>
            
        </div>
 @endforeach
</div>

 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					上传图片
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('album.photo.store',['_album_id'=>$_album_id]) }}" enctype="multipart/form-data">
			<div class="modal-body">
    	       
                    {{ csrf_field() }}        
                    <div class="form-group {{ $errors->has('lunbo') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label">选择图片</label>
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

    
    
 


<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					编辑图片
				</h4>
			</div>
			 <form class="form-horizontal" id="edit_form"  method="post" action="" enctype="multipart/form-data">
					<div class="modal-body">
				        {{ csrf_field() }}
            			{{ method_field('PUT') }}            
			            <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
			                <label class="col-sm-2 control-label">@lang('album::photo.url')</label>
			                <div class="col-sm-10">
			                    <input type="file" class="form-control" name="url" value="">
			                    @if ($errors->has('url'))
			                        <span class="help-block">
			                        <strong>{{ $errors->first('url') }}</strong>
			                    </span>
			                    @endif
			                </div>
			            </div>
			
			            <div class="form-group {{ $errors->has('like') ? 'has-error' : '' }}">
			                <label class="col-sm-2 control-label">@lang('album::photo.like')</label>
			                <div class="col-sm-10">
			                    <input type="text" class="form-control" id="like" name="like" value="">
			                    @if ($errors->has('like'))
			                        <span class="help-block">
			                        <strong>{{ $errors->first('like') }}</strong>
			                    </span>
			                    @endif
			                </div>
			            </div>
			
			            
						<div class="modal-footer">
							 	<button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
							    <button type="submit" class=" btn btn-primary">保存</button>     
						</div>
				           		
					</div>
		          
					
      		</form>
      
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>  




 
<script>


function edit_model(id,like){
	var url = $('#'+id).attr('name');
	$('#edit_form').attr('action',url);
	$('#like').val(like);
	$('#edit_modal').modal('show');
	return false;
	
}
</script>  
    
    
    
    
    
@endsection