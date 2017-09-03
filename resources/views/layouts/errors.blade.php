@if(count($errors) > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>@lang('main.errors'):</b>
                <ol>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div><!-- /.row -->
@endif