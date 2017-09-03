@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('album::photo.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('album.category.list') }}"><i class="fa fa-home"></i> @lang('album::category.title')</a></li>
            <li><a href="{{ route('album.album.list', ['_category_id' => $photo->album->_category_id]) }}"><i class="fa fa-home"></i> @lang('album::album.title')</a></li>
            <li><a href="{{ route('album.photo.list', ['_album_id' => $photo->_album_id]) }}"><i class="fa fa-home"></i> @lang('album::photo.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.view')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>@lang('album::photo.album')</th>
                <td>{{ $photo->album->name }}</td>
            </tr>
            <tr>
                <th>@lang('album::photo.url')</th>
                <td><img src="{{ $photo->url }}?imageMogr2/auto-orient/thumbnail/200x200/blur/1x0/quality/75|imageslim"></td>
            </tr>
            <tr>
                <th>@lang('album::photo.like')</th>
                <td>{{ $photo->like }}</td>
            </tr>
            <tr>
                <th>@lang('album::photo.created_at')</th>
                <td>{{ $photo->created_at }}</td>
            </tr>
        </table>
    </div>
@endsection