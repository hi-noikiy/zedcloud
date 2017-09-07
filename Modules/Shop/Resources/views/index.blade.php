@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <ol class="breadcrumb">            
            <li class="active"><i class="fa fa-edit"></i> <span>门店列表</span></li>
        </ol>
        <a data-toggle="modal" data-target="#mymodal"  class="pull-right btn btn-success">新增门店</a>
    </div><!-- /.row -->
@endsection

@section('content')
<script>

$.ajax({
	url:"https://api.huangyao.site/api/set_en",
	type:"get",
	dataType:'json',	
	success:function(res){
		
	 }
}); 
</script>
 
 
    <div class="table-responsive">
    
	<br>	
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>门店名称</th>
                <th>门店logo</th>
                 <th>状态</th>
                 <th>电话</th>
                 <th>appid</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
                              @foreach($companies as $key=>$company)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $company->name }}</td>
                                        <td><img class="img_show" style="width:50px;height:50px;" name="{{env('APP_CDN').$company->logo}} " src="{{ env('APP_CDN').$company->logo }}?imageMogr2/auto-orient/thumbnail/250x250/blur/1x0/quality/75|imageslim"></td>
                                       
                                        
                                        <td>@if($company->status == 1)失效  @else <span style="color:red">正常</span> @endif</td>
                                        <td>{{ $company->telephone }}</td>
                                        <td>{{ $company->appid }}</td>
                                         <td>
                                         <a href="{{ route('shop.shop.edit', ['shop_id' => $company->id]) }}" class="btn btn-xs btn-primary ">编辑</a>
                                         
                                         @if($company->status == 0)
                                          <a href="{{ route('shop.shop.destroy', ['shop_id' => $company->id]) }}" class="btn btn-xs btn-danger btn-delete">禁止</a>
                                         @else
                                           <a href="{{ route('shop.shop.undestroy', ['shop_id' => $company->id]) }}" class="btn btn-xs btn-success ">恢复正常</a>
                                         
                                         @endif

                                         </td>
                                                
                              
                                    </tr>
                                @endforeach
            </tbody>
        </table>

        <div class="pull-right">
            
        </div>
    </div>
    

    
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					新增门店
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('shop.shop.store') }}" enctype="multipart/form-data">
			<div class="modal-body">
		            {{ csrf_field() }}
		  <h4 style="text-align: center;">店面基本信息</h4>
           
            <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                <label class="col-sm-2 ">店面照片</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control"   name="cover">
                    @if ($errors->has('cover'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cover') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
           
           
		  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
		     <label class="col-sm-2">门店名称</label>
		     <div class="col-sm-8">
			     <input type="text" id="name" class="form-control" name="name">
			     @if ($errors->has('name'))
			     <span class="help-block">
			     <strong>{{ $errors->first('name') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		
		  <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
		     <label class="col-sm-2">联系电话</label>
		     <div class="col-sm-8">
			     <input required  type="text" id="phone" class="form-control" name="phone">
			     @if ($errors->has('phone'))
			     <span class="help-block">
			     <strong>{{ $errors->first('phone') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
	
		
		  <div class="form-group {{ $errors->has('addr') ? 'has-error' : '' }}">
		     <label class="col-sm-2">商家地址</label>
		     <div class="col-sm-8">
			     <input required  type="text" id="addr" class="form-control" name="addr">
			     @if ($errors->has('addr'))
			     <span class="help-block">
			     <strong>{{ $errors->first('addr') }}</strong>
			     </span>
			     @endif
		     </div>
		  </div>
		
	
		
		  <div class="form-group {{ $errors->has('latitude') ? 'has-error' : '' }}">
		     <label class="col-sm-2">地址经度</label>
		     <div class="col-sm-8">
			     <input required  type="text" id="latitude" class="form-control" name="latitude">
			     @if ($errors->has('latitude'))
			     <span class="help-block">
			     <strong>{{ $errors->first('latitude') }}</strong>
			     </span>
			     @endif
			     
		     </div>
		     
		  </div>
	
		
		  <div class="form-group {{ $errors->has('longitude') ? 'has-error' : '' }}">
		     <label class="col-sm-2">地址纬度</label>
		     <div class="col-sm-8">
			     <input required  type="text" id="longitude" class="form-control" name="longitude">
			     @if ($errors->has('longitude'))
			     <span class="help-block">
			     <strong>{{ $errors->first('longitude') }}</strong>
			     </span>
			     @endif
			     <a target="_blank" class="btn btn-warning" href="http://lbs.qq.com/tool/getpoint/index.html">去获取经纬度</a>
		     </div>
		  </div>
		  <div class="form-group {{ $errors->has('appid') ? 'has-error' : '' }}">
		     <label class="col-sm-2">app_id</label>
		     <div class="col-sm-8">
			     <input required  type="text" id="appid" class="form-control" name="appid">
			     @if ($errors->has('appid'))
			     <span class="help-block">
			     <strong>{{ $errors->first('appid') }}</strong>
			     </span>
			     @endif
		     </div>
		
		</div>
	
		
		  <div class="form-group {{ $errors->has('appsecret') ? 'has-error' : '' }}">
		     <label class="col-sm-2">app_secret</label>
		     <div class="col-sm-8">
			     <input required  type="text" id="appsecret" class="form-control" name="appsecret">
			     @if ($errors->has('appsecret'))
			     <span class="help-block">
			     <strong>{{ $errors->first('appsecret') }}</strong>
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

  
<div class="modal fade" id="mymodal_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					商品介绍
				</h4>
			</div>
			 <form class="form-horizontal" id="edit_form" method="post" action="" enctype="multipart/form-data">
			<div class="modal-body">

                       <span id="intro"></span>

                 </div>
			<div class="modal-footer">
				 	<button type="button" class="btn btn-default " data-dismiss="modal">关闭</button>
				  
			</div>
        </form>
        
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>  

    





    <script>
	$('#category').change(function(){
		var id = $(this).val();
		if(id == ''){
			return;
		}
		window.location.href = "{{route('product.product.list')}}" + "?_category_id=" + id;
	});

	function model_edit(id,price,old_price,unit,intro,name)
	{		
		var url = $('#'+id).attr('name');
		$('#edit_form').attr('action',url);
		$('#e_price').val(price);
		$('#e_old_price').val(old_price);
		$('#e_unit').val(unit);
		$('#e_intro').val(intro);
		$('#e_name').val(name);
		
		$('#mymodal_edit').modal('show');
		return false;		
	}
	function model_2(ex)
	{		
		
		$('#intro').html(ex);
		
		$('#mymodal_2').modal('show');
		return false;		
	}
</script>
@endsection

