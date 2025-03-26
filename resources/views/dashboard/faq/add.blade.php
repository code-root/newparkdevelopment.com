@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Add New FAQ</span>
        </h4>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">FAQ Information</h5>
                    </div>
                    <div id="error-messages" class="alert alert-danger d-none" role="alert">
                        <ul id="error-list"></ul>
                    </div>
                    <form id="add-item-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="question" class="form-label">Question</label>
                                    <input type="text" id="question" name="question" class="form-control" placeholder="Enter question" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="answer" class="form-label">Answer</label>
                                    <textarea id="answer" name="answer" class="form-control" rows="5" placeholder="Enter answer" required></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add New FAQ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add-item-form').on('submit', function(e) {
        e.preventDefault(); // منع الإرسال الافتراضي للنموذج
        $('#error-messages').addClass('d-none');
        $('#error-list').empty();

        $.ajax({
            url: "{{ route('faq.create') }}",
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                window.location.href = "{{ route('faq.index') }}"; // إعادة التوجيه عند النجاح
            },
            error: function(xhr) {
                $('#error-messages').removeClass('d-none');
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#error-list').append('<li>' + value[0] + '</li>');
                });
            }
        });
    });
</script>
@endsection
@endsection
