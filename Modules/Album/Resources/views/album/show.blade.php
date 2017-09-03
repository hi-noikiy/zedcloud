@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('album::album.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('album.category.list') }}"><i class="fa fa-home"></i> @lang('album::category.title')</a></li>
            <li><a href="{{ route('album.album.list', ['_category_id' => $album->_category_id]) }}"><i class="fa fa-home"></i> @lang('album::album.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.view')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>@lang('album::album.category')</th>
                <td>{{ $album->category->name }}</td>
            </tr>
            <tr>
                <th>@lang('album::album.cover')</th>
                <td><img src="{{ $album->cover }}?imageMogr2/auto-orient/thumbnail/200x200/blur/1x0/quality/75|imageslim"></td>
            </tr>
            <tr>
                <th>@lang('album::album.name')</th>
                <td>{{ $album->name }}</td>
            </tr>
            <tr>
                <th>@lang('album::album.like')</th>
                <td>{{ $album->like }}</td>
            </tr>
            <tr>
                <th>@lang('album::album.photo_number')</th>
                <td>{{ $album->photo_number }}</td>
            </tr>
            <tr>
                <th>@lang('album::album.created_at')</th>
                <td>{{ $album->created_at }}</td>
            </tr>
        </table>
    </div>
@endsection