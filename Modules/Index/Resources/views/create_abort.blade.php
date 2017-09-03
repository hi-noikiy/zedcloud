@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('index::main.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('index::main.set')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

   

<div class="row">
		<h4 class="modal-title" id="myModalLabel">
			添加关于我们
		</h4>
		 <form class="form-horizontal" method="post" action="{{ route('index.us.create') }}" enctype="multipart/form-data">

                {{ csrf_field() }}        
                <script src="{!!asset('/laravel-u-editor/ueditor.config.js')!!}"></script>
                <script src="{!!asset('/laravel-u-editor/ueditor.all.min.js')!!}"></script>
                <script style="width: 100%;height:500px;" id="container" name="content" type="text/plain"></script>
                <script type="text/javascript">                                           
                   var ue = UE.getEditor('container'); 
                </script>
			 <button type="submit" class=" btn btn-primary">保存</button>     		
		</form>

</div>

    
@endsection