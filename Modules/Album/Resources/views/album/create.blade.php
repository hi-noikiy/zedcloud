@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('album::album.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('album.category.list') }}"><i class="fa fa-home"></i> @lang('album::category.title')</a></li>
            <li><a href="{{ route('album.album.list', ['_category_id' => request('_category_id')]) }}"><i class="fa fa-home"></i> @lang('album::album.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.create')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="table-responsive">
        <form class="form-horizontal" method="post" action="{{ route('album.album.store') }}" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="_category_id" value="{{ request('_category_id') }}">

            <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('album::album.cover')</label>
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
                <label class="col-sm-2 control-label">@lang('album::album.name')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
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