<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="keyword" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <title>{{ env('APP_NAME') }}</title>

    <link href="{{ asset('/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <script src="{{ asset('/assets/js/ie-emulation-modes-warning.js') }}"></script>
     
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
   <script src="{{ asset('js/jquery-1.9.1.js') }}"></script>

  
</head>


<body>

<div class="container-fluid">
    <div class="row ">
        <div class="col-sm-3 col-md-2 sidebar admin-menu">
             <ul class="nav nav-sidebar">

                <li class="first"><a class="{{ Route::currentRouteNamed('index.index.list') ? 'active' : null }}" href="{{ route('index.index.list') }}"><span class="glyphicon glyphicon-file"></span>首页管理</a></li>
                <li class="first"><a class="{{ Route::currentRouteNamed('album.album.list') ? 'active' : null }}" href="{{ route('album.album.list') }}"><span class="glyphicon glyphicon-file"></span>相册管理</a></li>
<!--                 <li class="first"><a class="{{ Route::currentRouteNamed('product.category.list') ? 'active' : null }}" href="{{ route('product.category.list') }}"><span class="glyphicon glyphicon-minus-sign"></span>商品类型</a></li> -->
                <li class="first"><a class="{{ Route::currentRouteNamed('product.product.list') ? 'active' : null }}" href="{{ route('product.product.list') }}"><span class="glyphicon glyphicon-file"></span>商品管理</a></li>
                <li class="first"><a class="{{ Route::currentRouteNamed('user.visit.index') ? 'active' : null }}" href="{{ route('user.visit.index') }}"><span class="glyphicon glyphicon-file"></span>用户管理</a></li>
               
                
                <li class="first"><a class="{{ Route::currentRouteNamed('user.apply.combo') ? 'active' : null }}" href="{{ route('user.apply.combo') }}"><span class="glyphicon glyphicon-file"></span>预约管理</a></li>

 
                <li class="first"><a class="{{ Route::currentRouteNamed('link.index') ? 'active' : null }}" href="{{ route('link.index') }}"><span class="glyphicon glyphicon-file"></span>商家信息</a></li>
                <li class="first"><a class="{{ Route::currentRouteNamed('logout') ? 'active' : null }}" href="{{ route('logout') }}"><span class="glyphicon glyphicon-file"></span>退出登录</a></li>

                
                 
<!--            <li class="first"><a class="{{ Route::currentRouteNamed('activity.activity.list') ? 'active' : null }}" href="{{ route('activity.activity.list') }}"><span class="glyphicon glyphicon-time"></span>activity</a></li> -->
                
                <!--  <li class="first">
                	<a><span class="glyphicon glyphicon-file"></span>商品管理<b class="caret pull-right"></b></a>
                	<ul class="nav submenu">                		
                			
                			<li><a class="{{ Route::currentRouteNamed('product.category.list') ? 'active' : null }}" href="{{ route('product.category.list') }}"><span class="glyphicon glyphicon-minus-sign"></span>商品类型</a></li>
                			<li><a class="{{ Route::currentRouteNamed('product.product.list') ? 'active' : null }}" href="{{ route('product.product.list') }}"><span class="glyphicon glyphicon-minus-sign"></span> 商品列表</a></li>
	
                	</ul>
                </li> -->
            </ul>
            
			<style>
				
				 .first a{
				 	color:#fff;
				 	font-size:20px;
				 }
				 .first a:hover{
				 	color:#000;
				 	font-size:20px;
				 	background:#111;
				 }
		
				 .submenu a{
				    color:#ccc;
				 	font-size:16px;
				 	text-align:center;
				 	margin-left:-100px;
				 	
				 }
				 .submenu a:hover{
				 	font-size:16px;	

				 }
				 .submenu{
				 	display:none;
				 }
				 
				 ul.active-sub{
				 	display:block;
				 }
				 .sidebar{
				 	background:#555;
				 	margin-top:-5px;
				 }

				 .glyphicon {
				 	margin-right:15px;
				 }
				 
    			   .first .active{
    			   		color:#fff;
    			   		background:#111;
    			   }
                       body{
	               background:#ddd;
                       }
				 
			</style>
			
			<script>
				$(".nav-sidebar .first").on("click",function(){
					if($(this).find('.active').length > 0){
						
					}else{
						$(".nav-sidebar .first .submenu").hide();						
					}
					$(this).children('ul').slideDown();
	
				});
				
				if($(".nav-sidebar .active").parents(".submenu li").length > 0){
					$(".nav-sidebar .active").parents(".submenu").show();
				}
	
	
			</script>
            
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <style>
    .page-header span{
	color:#fff;
    	font-size:22px;
    }
    .breadcrumb{
	   height:50px;
    }
</style>
            @yield('breadcrumb')
            @include('layouts.alert')
            @include('layouts.errors')
            @yield('content')
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="delete-modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('main.destroy')</h4>
            </div>
            <div class="modal-body">
                <p>@lang('main.confirm.destroy')</p>
            </div>
            <div class="modal-footer">
                <form id="delete-modal-form" action="" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('main.cancel')</button>
                    <button type="submit" class="btn btn-danger">@lang('main.destroy')</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- img_show modal -->
@include("layouts.img_modal")


   
 <div class="modal fade" id="myModal_edit" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel-edit">
					编辑分类
				</h4>
			</div>
			 <form class="form-horizontal"  id="edit_form"  action="" method="POST">
			 		
				<div class="modal-body"> 			 
						{{ csrf_field() }}  
	                    {{ method_field('PUT') }}                 
	                    <div class="form-group">
	                        <label class="col-sm-2 control-label">类型名称</label>
	                        <div class="col-sm-8">
	 							<input  type="text" id="name" class="form-control" name="name">
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




 <div class="modal fade" id="myModal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel-add">
					
				</h4>
			</div>
			 <form class="form-horizontal" id="add_form" method="post" action="" enctype="multipart/form-data">
			<div class="modal-body">
		            {{ csrf_field() }}
		
		            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
	                <label class="col-sm-2 control-label">@lang('studio::category.name')</label>
	                <div class="col-sm-10">
	                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
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



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('/assets/js/vendor/jquery.min.js') }}"><\/script>')</script>

<script src="{{ asset('/dist/js/bootstrap.min.js') }}"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="{{ asset('/assets/js/vendor/holder.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
</body>
</html>

<script>
    $('.btn-delete').on('click', function () {
        var url = $(this).attr('href');
        $('#delete-modal-form').attr('action', url);
        $('#delete-modal').modal();
        return false;
    });

	$(".img_show").on('click',function(){
		var url = $(this).attr('name');
		$('#dlg_img').attr('src',url);
		$('#img_modal').modal('show');
		return false;
		
	});


	 $('.category-edit').on('click', function () {
	    	var name = $(this).attr('name');
	    	$('#name').val(name);
	    	var action = $(this).attr('href');	    	
	    	$('#edit_form').attr('action', action);
	    	$('#myModal_edit').modal();
	    	return false;
	    });
	    

	 $('.category-add').on('click', function () {
	    	var type_name = $(this).html();
	    	$('#myModalLabel-add').html(type_name);
	    	var action = $(this).attr('href');
	    	$('#add_form').attr('action', action);	
	    	$('#myModal_add').modal();
	    	return false;
	    });

</script>











