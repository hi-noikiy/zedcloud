@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('product::photo.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            
            <li><a href="{{ route('product.product.list', ['_category_id' => $product->_category_id]) }}"><i class="fa fa-home"></i> @lang('product::product.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> 图集</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="table-responsive">

        <a data-toggle="modal" data-target="#mymodal"  class="pull-right btn btn-success">上传该商品图片</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('product::photo.product')</th>
                <th>商品图片</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($photos as $key=>$photo)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $photo->product_name }}</td>
                    <td><img class="img_show" style="width:100px;height:100px;" src="{{ $photo->url }}"></td>
                    <td>                       
                        <a href="{{ route('product.photo.destroy', ['_photo_id' => $photo->_id]) }}" class="btn btn-danger  btn-delete">@lang('main.destroy')</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pull-right">
            {{ $photos->links() }}
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
					上传图片
				</h4>
			</div>
			 <form class="form-horizontal" method="post" action="{{ route('product.photo.store') }}" enctype="multipart/form-data">
				<div class="modal-body">
					      {{ csrf_field() }}
					
					      
           				<input type="hidden" name="_product_id" value="{{ request('_product_id') }}">
			
				          <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
			                <label class="col-sm-2 control-label">@lang('product::photo.url')</label>
			                <div class="col-sm-10">
			                    <input type="file" class="form-control" name="url">
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
				    <button type="submit" class=" btn btn-primary">上传</button>     
			</div>
        </form>
        
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>  
@endsection