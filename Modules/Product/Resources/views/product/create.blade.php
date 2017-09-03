@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('product::product.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('product.category.list') }}"><i class="fa fa-home"></i> @lang('product::category.title')</a></li>
            <li><a href="{{ route('product.product.list', ['_category_id' => request('_category_id')]) }}"><i class="fa fa-home"></i> @lang('product::product.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.create')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="table-responsive">
        <form class="form-horizontal" method="post" action="{{ route('product.product.store') }}" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="_category_id" value="{{ request('_category_id') }}">

            <div class="form-group {{ $errors->has('sale_type') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('combo::combo.sale_type')</label>
                <div class="col-sm-10">
                    <select class="form-control" name="sale_type">
                        <option value="0">@lang('main.select')</option>
                        @foreach($sale_types as $key=>$sale_type)
                            <option value="{{ $key }}" @if($key == old('sale_type')) selected @endif>{{ $sale_type }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('sale_type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('sale_type') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('product::product.cover')</label>
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
                <label class="col-sm-2 control-label">@lang('product::product.name')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('combo::combo.price')</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="price" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('sales_volume') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('combo::combo.sales_volume')</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="sales_volume" value="{{ old('sales_volume') }}">
                    @if ($errors->has('sales_volume'))
                        <span class="help-block">
                            <strong>{{ $errors->first('sales_volume') }}</strong>
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