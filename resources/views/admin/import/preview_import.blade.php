@section('innerContent')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Предпросмотр
            </h1>
            @if(Session::has('message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table id="datatable-import">
                <thead>
                    <tr>
                        <th>number_task</th>
                        <th>image</th>
                        <th>experience</th>
                        <th>gold</th>
                        <th>grade</th>
                        <th>subject_id</th>
                        <th>answer</th>
                        <th>detail</th>
                        <th>set_of_task_id</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            var data = {!! $data !!};
            
            $('#datatable-import').DataTable({
                data: data
            });
        });
    </script>
@stop
