@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">FAQ</span>
        </h4>
        <div class="card">
            <div class="card-header">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Data Table FAQ</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                <a href="{{ route('faq.create.page') }}" class="send-model dt-button create-new btn btn-primary waves-effect waves-light">
                                    <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New FAQ</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <table id="data-x" class="table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@section('footer')
<script>
$(document).ready(function() {
    var table = $('#data-x').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('faq.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'question' },
            { data: 'answer' },
            {
                data: 'id',
                render: function(data, type, row) {
                    var editUrl = `{{ route("faq.edit", ":id") }}`.replace(':id', data);
                    return `
                        <a href="${editUrl}" class="dropdown-item">
                            <i class="fa fa-pencil"></i> edit
                        </a>
                        <a href="#" class="dropdown-item toggle-Update" data-id="${data}" data-Update="${row.status}">
                            <i class="fa fa-toggle-${row.status == 1 ? 'on' : 'off'}"></i> ${row.status == 1 ? 'Disable' : 'Enable'}
                        </a>
                    `;
                }
            }
        ]
    });


    $('#data-x').on('click', '.toggle-Update', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: "{{ route('faq.toggleStatus') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "model": "Category",
                status
            },
            success: function(response) {
                table.ajax.reload();
            }
        });
    });

    $('#data-x').on('click', '.delete-faq', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('faq.destroy') }}",
            type: "DELETE",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            success: function(response) {
                table.ajax.reload();
            }
        });
    });
});
</script>
@endsection
@endsection
