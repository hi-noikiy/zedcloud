@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('album::photo.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('album.category.list') }}"><i class="fa fa-home"></i> @lang('album::category.title')
                </a></li>
            <li><a href="{{ route('album.album.list', ['_category_id' => $album->_category_id]) }}"><i
                            class="fa fa-home"></i> @lang('album::album.title')</a></li>
            <li><a href="{{ route('album.photo.list', ['_album_id' => $album->_id]) }}"><i
                            class="fa fa-home"></i> @lang('album::photo.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.create')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="table-responsive">
        <form class="form-horizontal" method="post" action="{{ route('album.photo.store') }}"
              enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="_album_id" value="{{ request('_album_id') }}">

            <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('album::photo.url')</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="url">
                    @if ($errors->has('url'))
                        <span class="help-block">
                            <strong>{{ $errors->first('url') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('like') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('album::album.like')</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="like" value="{{ old('like') }}">
                    @if ($errors->has('like'))
                        <span class="help-block">
                            <strong>{{ $errors->first('like') }}</strong>
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