@section('innerContent')

    <div class="row">
        <div class="col-lg-12">
            <br>
            @if(Session::has('message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
    </div>
    @include('admin.user.interface')
@stop