@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <ol class="breadcrumb">            
            <li class="active"><i class="fa fa-edit"></i> <span>商品列表</span></li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
<script>
/* alert(5);
$.ajax({
	url:"https://api.xhangjia.com/mengzhu/gamer/add",
	type:"post",
	dataType:'json',
	data:{
		openid:'oe_RNwDhwp0rZNyEkXwW14rBNte41234',
		baby_sex:1,
		baby_name:'哈哈',
		baby_pic:'data:image/jpeg;base64,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%E2%80%A6%E2%80%A6',
		  baby_age:4,
		baby_xingzuo : 8,
		baby_introduce : '啊舒服打发打发烦',
		parent_name : '来来来',
		parent_phone : '1241234',		
		provice_id : 'guangdong'
	},
	success:function(res){
		alert(res.status)
	 }
}); */
</script>
 
 
    <div class="table-responsive">
    <a data-toggle="modal" data-target="#mymodal"  class="pull-right btn btn-success">新增商品</a>
		
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>原价</th>
                 <th>现价</th>
                 <th>单位</th>
                 <th>商品介绍</th>
                 <th>首页展示</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $key=>$product)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><img class="img_show" style="width:50px;height:50px;" name="{{env('APP_CDN').$product->cover}} " src="{{ env('APP_CDN').$product->cover }}?imageMogr2/auto-orient/thumbnail/250x250/blur/1x0/quality/75|imageslim"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->old_price }}</td>
                    <td>{{ $product->price }}</td>
                    
                    <td>{{ $product->unit }}</td>
                    <td><a onclick="javascript:model_2('{{$product->introduce}}')"  class="btn btn-xs btn-primary ">查看</a></td>
                    <td>@if($product->hot == 1)<span style="color:blue">是</span>@else否@endif</td>
                    <td>
<a onclick="javascript:model_edit('{{$product->_id}}','{{$product->price}}','{{$product->old_price}}','{{$product->unit}}','{{$product->introduce}}','{{$product->name}}')" id="{{$product->_id}}" name="{{ route('product.product.update', ['_product_id' => $product->_id]) }}" class="btn btn-xs btn-primary ">编辑</a>
<a href="{{ route('product.product.destroy', ['_product_id' => $product->_id]) }}" class="btn btn-danger btn-xs  btn-delete">删除</a>
@if($product->hot == 0)
<a href="{{ route('product.product.sethot', ['_product_id' => $product->_id]) }}" class="btn btn-warning btn-xs">首页展示</a>
@else
<a href="{{ route('product.product.unsethot', ['_product_id' => $product->_id]) }}" class="btn btn-warning btn-xs">取消首页展示</a>
    @endif
                     </td>
          
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pull-right">
            {{ $products->links() }}
        </div>
    </div>
    
    
<div class="modal fade" id="mymodal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					编辑商品
				</h4>
			</div>
			 <form class="form-horizontal" id="edit_form" method="post" action="" enctype="multipart/form-data">
			<div class="modal-body">
		            {{ csrf_field() }}
		            {{ method_field('PUT') }}
		
		      

              <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('product::product.cover')</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control"   name="cover">
                    @if ($errors->has('cover'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cover') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('product::product.name')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="e_name"   name="name" placeholder="请输入商品名称，最多10个字" maxlength="10" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">现价</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="e_price"  placeholder="请输入商品价格"  name="price" value="{{ old('price') }}" required>
                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            
             <div class="form-group {{ $errors->has('old_price') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">原价</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control"  id="e_old_price" placeholder="请输入商品原价格，选填" name="old_price" value="{{ old('old_price') }}" >
                    @if ($errors->has('old_price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('old_price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('unit') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">单位</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="e_unit" placeholder="请输入单位，如：一只、一包、一条、一箱、一件" name="unit" value="{{ old('unit') }}" required>
                    @if ($errors->has('unit'))
                        <span class="help-block">
                            <strong>{{ $errors->first('unit') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
             <div class="form-group {{ $errors->has('intro') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">介绍</label>
                <div class="col-sm-10">
                    <textarea placeholder="请输入商品介绍" id="e_intro" rows="4" name="intro" cols="60"></textarea>
                    @if ($errors->has('intro'))
                        <span class="help-block">
                            <strong>{{ $errors->first('intro') }}</strong>
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

    
    
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					新增商品
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('product.product.store') }}" enctype="multipart/form-data">
			<div class="modal-body">
		            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('product::product.cover')</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control"   name="cover">
                    @if ($errors->has('cover'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cover') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('product::product.name')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  name="name" placeholder="请输入商品名称，最多10个字" maxlength="10" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">现价</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="请输入商品价格"  name="price" value="{{ old('price') }}" required>
                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            
             <div class="form-group {{ $errors->has('old_price') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">原价</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control"  placeholder="请输入商品原价格，选填" name="old_price" value="{{ old('old_price') }}" >
                    @if ($errors->has('old_price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('old_price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('unit') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">单位</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="请输入单位，如：一只、一包、一条、一箱、一件" name="unit" value="{{ old('unit') }}" required>
                    @if ($errors->has('unit'))
                        <span class="help-block">
                            <strong>{{ $errors->first('unit') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
             <div class="form-group {{ $errors->has('intro') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">介绍</label>
                <div class="col-sm-10">
                    <textarea placeholder="请输入商品介绍" rows="4" name="intro" cols="60"></textarea>
                    @if ($errors->has('intro'))
                        <span class="help-block">
                            <strong>{{ $errors->first('intro') }}</strong>
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

