@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Account Settings /</span> Profile
            </h4>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Profile Details</h5>
                        <!-- Account -->
                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                            <div class="card-body">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="/storage/app/public/{{ $data->avatar }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload New Photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" name="avatar" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                        </label>
                                        <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>
                                        <p class="text-muted mb-0">Allowed JPG, GIF, or PNG. Max size 800K</p>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input class="form-control" type="text" id="firstName" name="firstName"
                                            value="{{ $data->name }}" autofocus />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input class="form-control" type="email" id="email" name="email"
                                            value="{{ $data->email }}" placeholder="example@example.com" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">KSA (+966)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                                value="{{ $data->phone }}" placeholder="0123456789" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                        <!-- /Account -->
                    </div>
                    <div class="card mb-4">
                        <h5 class="card-header">Change Password</h5>
                        <form id="formChangePassword">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Content -->
    </div>
@endsection

@section('footer-script')
    <script>
            $('#formChangePassword').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("admin.profile.updatePassword") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.success);
                $('#formChangePassword')[0].reset(); // إعادة تعيين الحقول
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON?.error || 'An error occurred, please try again';
                alert(errorMessage);
            }
        });
    });
        $('#formAccountSettings').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("admin.profile.update") }}', // Ensure this route exists
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.status === 'success') {
                        // Update the displayed photo on success
                        if(response.avatar) {
                            $('#uploadedAvatar').attr('src', response.avatar);
                        }
                        alert('Changes saved successfully');
                    } else {
                        alert('An error occurred, please try again');
                    }
                },
                error: function(response) {
                    alert('An error occurred, please try again');
                }
            });
        });

        // AJAX for resetting the image
        $('.account-image-reset').on('click', function() {
            $('#uploadedAvatar').attr('src', '../../assets/img/avatars/1.png');
            $('#upload').val('');
        });

        // Preview image immediately after selecting a file
        $('#upload').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#uploadedAvatar').attr('src', URL.createObjectURL(file));
            }
        });
    </script>
@endsection
