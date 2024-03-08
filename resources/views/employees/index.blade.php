@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Empleados</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="employees-table">
                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombres</th>
                                <th>Cargo</th>
                                <th>Régimen</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')

<script>
$(function() {
    $('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'getEmployees',
        columns: [
            { data: 'dni', name: 'dni', orderable: false, searchable: false},
            { data: 'plastname', name: 'plastname' },
            { data: 'mlastname', name: 'mlastname'},
            { data: 'name', name: 'name'},
            { data: 'position', name: 'position', orderable: false, searchable: false},
            { data: 'regimen', name: 'regimen', orderable: false, searchable: false},

        ],
        order: [[1, 'asc'], [2, 'asc'], [3, 'asc']],
        columnDefs: [{
            targets: 0,
            className: 'dt-right'
        }]
    });
});
</script>


@endpush