@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')
@section('body')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Edit Category</span>
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
                        <h5 class="card-title mb-0">Category Information</h5>
                    </div>
                    <form method="post" action="{{ route('category.update', $data->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $data->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ $data->title }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>On display</option>
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Hidden</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="color_class">Color Class</label>
                                    <input type="text" id="color_class" name="color_class" class="form-control" value="{{ $data->color_class }}">
                                </div>
                            </div>

                            <div id="language-fields">
                                <!-- سيتم ملء الحقول هنا بواسطة الجافاسكريبت -->
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script>
$(document).ready(function() {
    // عند تغيير اللغة
    $('#language').change(function() {
        var languageId = $(this).val();
        var item_id = {{ $data->id }}; // الحصول على ID category

        // إضافة الكود اللازم لجلب البيانات بناءً على اللغة المختارة
    });
});
</script>
@endsection
