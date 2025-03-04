@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"> <span class="text-muted fw-light">Users </span> </h4>
        <div class="card">
            <div class="card-header">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">DataTable with Buttons</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons">
                                @can('create-users')
                                    <a class="btn btn-primary waves-effect waves-light" href="{{ route('users.create') }}">Create New User</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <table id="example" class="dt-fixed header table border-top dataTable dtr-column">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @can('view-users')
                                @foreach ($data as $key => $user)
                                    <tr id="user-row-{{ $user->id }}">
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <label style="color: #257311;font-family: system-ui;">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm toggle-status {{ $user->active == 1 ? 'btn-success' : 'btn-secondary' }}"
                                                    data-id="{{ $user->id }}">
                                                {{ $user->active == 1 ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>

                                        <td>
                                            <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
                                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endcan
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script>
    // Enable user status toggle button using AJAX
    $(document).on('click', '.toggle-status', function(){
        var button = $(this);
        var userId = button.data('id');

        $.ajax({
            url: '{{ route("users.toggleStatus") }}', // Ensure this route exists in your routes file
            type: 'POST',
            data: {
                id: userId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success){
                    // تحديث الزر بناءً على الحالة الجديدة للمستخدم
                    if(response.active == 1){
                        button.removeClass('btn-secondary').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-secondary').text('Inactive');
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            },
            error: function(){
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>
@endsection
