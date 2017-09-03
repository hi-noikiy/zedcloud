@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>商品分类</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li class="active"><i class="fa fa-edit"></i>商品分类</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="table-responsive">

        <a href="{{ route('product.category.store') }}" class="category-add pull-right btn btn-success">新建商品分类</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('product::category.name')</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $key=>$category)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <a name="{{ $category->name }}" href="{{ route('product.category.update', ['_category_id' => $category->_id]) }}" class="category-edit btn btn-primary ">@lang('main.edit')</a>
                        <a href="{{ route('product.category.destroy', ['_category_id' => $category->_id]) }}" class="btn btn-danger  btn-delete">@lang('main.destroy')</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pull-right">
            {{ $categories->links() }}
        </div>
    </div>
@endsection