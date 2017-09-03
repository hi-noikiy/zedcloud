<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>全景</title>
     <!-- Bootstrap core CSS -->
    <link href="{{ asset('/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/assets/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
    <script src="{{ asset('/assets/js/ie-emulation-modes-warning.js') }}"></script>
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
	<META HTTP-EQUIV="Expires" CONTENT="0"> 
    <meta charset="UTF-8" />
	<meta name="renderer" content="webkit">
	<meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />	
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/zui.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/zui-theme.css') }}">	
	<link rel="stylesheet" href="{{ asset('css/redefine.css') }}">		
	<link rel="stylesheet" href="{{ asset('css/fileinput.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/qiniu_main.css') }}">
	
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/jquery-1.9.1.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>	
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/datetimepicker.js') }}"></script>						
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/zui.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/common.js') }}"></script>
	</head> 
<script>
	var up_url = "{{ env('QINIU_UP') }}";
	var around_post_url = "{{ route('clothing.around.add') }}";
	var album_post_url = "{{ route('album.aubum.addpics') }}";
	
	var act_token = "{{ route('clothing.get_token') }}";
	var m_url = "{{ route('clothing.around.list') }}";	
	var qn_video_token;
	var videoParams={} ;
	var category = "{{ $_category_id }}";
	var list = "{{ route('clothing.clothing.list',['_category_id'=>$_category_id]) }}";
	var photo_list = "{{ route('album.photo.list',['_album_id'=>$_album_id]) }}";
	var album_id = "{{ $_album_id }}";
</script>      
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">@lang('main.toggle')</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('@lang('main.logout')')){document.getElementById('logout-form').submit()}">
                        @lang('main.logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">{{ csrf_field() }}</form>
                </li>
            </ul>
        </div>
    </div>
</nav>

	<script language="JavaScript" type="text/javascript" src="{{ asset('js/fileinput-v4.34.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/fileinput_locale_zh.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/chosen.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/plupload/moxie.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/plupload/plupload.dev.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/kr/work_add_album.js?16') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/qiniu.min.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('js/qiniu_ui.js') }}"></script>
		
	<link rel="stylesheet" href="{{ asset('css/qiniu_main.css') }}">
    <div class="container">	
     <div class="row page-header">
        <h2>批量上传样片</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('album.album.list',['_category_id'=>$_category_id]) }}"><i class="fa fa-home"></i> @lang('album::album.title')</a></li>
            <li><a href="{{ route('album.photo.list',['_album_id'=>$_album_id]) }}"><i class="fa fa-home"></i> 图集</a></li>
            <li class="active"><i class="fa fa-edit"></i> 图片上传</li>
        </ol>
    </div><!-- /.row -->
	 <div class="update_div" style="height: 600px;margin-left: auto;margin-right: auto;">						
		 <div class="tab-pane fade active in" id="object_around">	    
		  	   <div class="row" style="margin-top:20px">
		  	    	<div class="col-md-12">
		  	    		<input id="albumUpload" name="file" type="file" multiple="" accept="image/jpeg,image/png" class="">
		  	    	</div>
		  	   </div> 
		  	   <div class="row" style="margin-top:20px">
				 	<div class="col-md-12">
				 		<button class="btn btn-block btn-primary" type="button" id="publish_album">立即上传</button>
				 	</div>
			   </div>
	  	  </div>       
       </div>     
      </div> 		 
<!--上传成功弹框-->
<div class="modal fade" id="myModal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">	     
	      <h4 class="modal-title">提示：</h4>
	    </div>
	    <div class="modal-body">
	      <p class="text-muted"><img src="{{asset('images/loading.gif')}}" alt="">上传完成，大概需要2~5分钟，请等待后台处理...</p>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-primary"  style="display:none" onclick="">确定</button>
	    </div>
	  </div>
	</div>
</div>   
				 
</body>
</html>
