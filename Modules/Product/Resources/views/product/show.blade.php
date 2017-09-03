@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('product::product.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('product.category.list') }}"><i class="fa fa-home"></i> @lang('product::category.title')</a></li>
            <li><a href="{{ route('product.product.list', ['_category_id' => $product->_category_id]) }}"><i class="fa fa-home"></i> @lang('product::product.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.view')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>@lang('product::product.category')</th>
                <td>{{ $product->category->name }}</td>
            </tr>
            <tr>
                <th>@lang('product::product.sale_type')</th>
                <td>{{ $product->sale_type_text }}</td>
            </tr>
            <tr>
                <th>@lang('product::product.cover')</th>
                <td><img src="{{ $product->cover }}?imageMogr2/auto-orient/thumbnail/200x200/blur/1x0/quality/75|imageslim"></td>
            </tr>
            <tr>
                <th>@lang('product::product.name')</th>
                <td>{{ $product->name }}</td>
            </tr>

            <tr>
                <th>@lang('product::product.price')</th>
                <td>{{ $product->price }}</td>
            </tr>

            <tr>
                <th>@lang('product::product.sales_volume')</th>
                <td>{{ $product->sales_volume }}</td>
            </tr>
            <tr>
                <th>@lang('product::product.created_at')</th>
                <td>{{ $product->created_at }}</td>
            </tr>
        </table>
    </div>
@endsection