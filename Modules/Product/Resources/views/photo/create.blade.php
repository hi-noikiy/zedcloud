@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('product::photo.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('product.category.list') }}"><i class="fa fa-home"></i> @lang('product::category.title')</a></li>
            <li><a href="{{ route('product.product.list', ['_category_id' => $product->_category_id]) }}"><i class="fa fa-home"></i> @lang('product::product.title')</a></li>
            <li><a href="{{ route('product.photo.list', ['_product_id' => $product->_id]) }}"><i class="fa fa-home"></i> @lang('product::photo.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.create')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="table-responsive">
        <form class="form-horizontal" method="post" action="{{ route('product.photo.store') }}" enctype="multipart/form-data">

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

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">@lang('main.submit')</button>
                </div>
            </div>

        </form>
    </div>
@endsection