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
            <span class="text-muted fw-light">Pages </span><span>Management</span>
        </h4>

        <div class="app-ecommerce">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <button class="btn btn-primary" id="addNewPageBtn">Add New Page</button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="pagesTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pages as $page)
                                            <tr>
                                                <td>{{ $page->id }}</td>
                                                <td class="name">{{ $page->name }}</td>
                                                <td>
                                                    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-warning">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for adding new page -->
        <div class="modal fade" id="addPageModal" tabindex="-1" aria-labelledby="addPageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPageModalLabel">Add New Page</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addPageForm">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Page</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
<script>
    $(document).ready(function() {
        $('#addNewPageBtn').click(function() {
            $('#addPageModal').modal('show');
        });

        $('#addPageForm').on('submit', function(e) {
            e.preventDefault();
            const data = $(this).serialize() ;

            $.ajax({
                url: "{{ route('pages.store') }}",
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#addPageModal').modal('hide');
                    location.reload(); // Reload the page to see the new page
                },
                error: function(xhr) {
                    // Handle errors here
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
@endsection
