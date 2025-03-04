@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-2">Roles List</h4>
            <p>A role provided access to predefined menus and features so that depending on <br> assigned role an
                administrator can have access to what user needs.</p>
            <div class="row g-4">
                @foreach ($rolesWithUsers as $role)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="fw-normal">Total {{ $role->users->count() ?? 0 }} users</h6>
                                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                        @foreach ($role->users as $user)
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                                class="avatar avatar-sm pull-up" aria-label="{{ $user->name }}"
                                                data-bs-original-title="{{ $user->name }}">
                                                <img class="rounded-circle"
                                                    src="https://ui-avatars.com/api/?name={{ $user->name }}"
                                                    alt="Avatar">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div class="role-heading">
                                        <h4 class="mb-1">{{ $role->name }}</h4>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="role-edit-modal"><small>Edit
                                                Role</small></a>
                                    </div>
                                    <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="../../assets/img/illustrations/sitting-girl-with-laptop-dark.png"
                                    class="img-fluid" alt="Image" width="120"
                                    data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                                    data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                    class="btn btn-primary mb-3 text-nowrap add-new-role">Add New Role</button>
                                <p class="mb-0">Add role, if it does not exist</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <!-- Role Table -->
                    <div class="card">
                        <div class="card-datatable table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <table class="datatables-users table border-top dataTable no-footer dtr-column"
                                    id="example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    {{-- roles-edit' --}}
                                                    <a class="btn btn-info"
                                                        href="{{ route('roles.show', $role->id) }}">Show</a>

                                                    @if (auth()->user()->can('write-roles'))
                                                        <a class="btn btn-primary"
                                                            href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                    @endif
                                                    @can('write-roles')
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!--/ Role Table -->
                </div>
            </div>
            <!--/ Role cards -->

            <!-- Add Role Modal -->
            <!-- Add Role Modal -->
            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="text-center mb-4">
                                <h3 class="role-title">Add New Role</h3>
                                <p>Set role permissions</p>
                            </div>
                            <!-- Add role form -->
                            <form id="addRoleForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework"
                                onsubmit="return false" novalidate="novalidate">
                                <div class="col-12 mb-4 fv-plugins-icon-container">
                                    <label class="form-label" for="modalRoleName">Role Name</label>
                                    <input type="text" id="modalRoleName" name="modalRoleName" class="form-control"
                                        placeholder="Enter a role name" tabindex="-1">
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h4>Role Permissions</h4>
                                    <!-- Permission table -->

                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                                @foreach ($permissionsData as $modelName => $modelPermissions)
                                                    <tr>
                                                        <td class="text-nowrap fw-medium">{{ $modelName }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @foreach ($modelPermissions as $permission)
                                                                    <div class="form-check me-3 me-lg-5">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="permissions[{{ $permission['id'] }}]" id="{{ $permission['id'] }}"
                                                                            {{ $permission['isChecked'] ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="{{ $permission['description'] }}">{{ $permission['description'] }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" id="role_done"
                                        class="btn btn-primary me-sm-3 me-1">Submit</button>
                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">Cancel</button>
                                </div>
                                <input type="hidden">
                            </form>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Add Role Modal -->

            <!-- / Add Role Modal -->
        </div>
        <!-- / Content -->



        <div class="content-backdrop fade"></div>
    </div>
@endsection
@section('footer-script')

    <script>
        $(document).ready(function() {
            $('#role_done').on('click', function(event) {
                event.preventDefault();
                var formData = new FormData(document.getElementById('addRoleForm'));
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('roles.store') }}', // استبدل بعنوان النهاية الخاص بك
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    processData: false, // تعيين processData إلى false
                    contentType: false, // تعيين contentType إلى false
                    success: function(response) {
                        swal({
                            icon: 'success',
                            title: response.msg,
                            showCancelButton: true,
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle errors and display them next to the input fields
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.text-danger').remove();
                            $('#store-form input').on('input', handleInputChange);

                            $.each(errors, function(key, value) {
                                $('#' + key).after('<div class="text-danger">' + value[
                                    0] + '</div>');
                            });
                        } else {
                            console.log(error);
                        }
                    }
                });
            });
        });
    </script>
@endsection
