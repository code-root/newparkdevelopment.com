@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit FAQ</span>
        </h4>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">FAQ Information</h5>
                    </div>
                    <form method="post" action="{{ route('faq.update', $data->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="question" class="form-label">Question</label>
                                    <input type="text" id="question" name="question" class="form-control" value="{{ $data->question }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="answer" class="form-label">Answer</label>
                                    <textarea id="answer" name="answer" class="form-control" rows="5" required>{{ $data->answer }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update FAQ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
