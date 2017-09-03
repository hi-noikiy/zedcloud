@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('product::category.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('product.category.list') }}"><i class="fa fa-home"></i> @lang('product::category.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.view')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
    <table class="table table-bordered">
        <tr>
            <th>@lang('product::category.name')</th>
            <td>{{ $category->name }}</td>
        </tr>
        <tr>
            <th>@lang('product::category.created_at')</th>
            <td>{{ $category->created_at }}</td>
        </tr>
    </table>
@endsection