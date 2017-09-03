<div class="row">
    <div class="col-lg-12">
        @if(session('alert-warning'))
            <div class="alert alert-dismissable alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('alert-warning') }}
            </div>
        @endif
        @if(session('alert-danger'))
            <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('alert-danger') }}
            </div>
        @endif
        @if(session('alert-success'))
            <div class="alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('alert-success') }}
            </div>
        @endif
        @if(session('alert-info'))
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('alert-info') }}
            </div>
        @endif
    </div>
</div><!-- /.row -->