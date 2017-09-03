@extends('layouts.app')

@section('breadcrumb')
    <div class="row page-header">
        <h2>@lang('product::category.title')</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> @lang('menu.home')</a></li>
            <li><a href="{{ route('product.category.list') }}"><i class="fa fa-home"></i> @lang('product::category.title')</a></li>
            <li class="active"><i class="fa fa-edit"></i> @lang('main.create')</li>
        </ol>
    </div><!-- /.row -->
@endsection

@section('content')

    <div class="table-responsive">
        <form class="form-horizontal" method="post" action="{{ route('product.category.store') }}" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label class="col-sm-2 control-label">@lang('product::category.name')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
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