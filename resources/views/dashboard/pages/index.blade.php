@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Pages List</h4>
            <a href="{{ route('pages.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Page
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>{{ $page->name }}</td>
                                <td>{{ $page->slug }}</td>
                                <td><span class="badge bg-primary">{{ ucfirst($page->type) }}</span></td>
                                <td>{{ $page->created_at->format('Y-m-d') }}</td>
                                <td class="text-end">
                                    {{-- <a href="{{ route('pages.show', $page->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a> --}}
                                    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this page?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if($pages->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No pages found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="m-3">
                {{ $pages->links() }} {{-- Laravel Pagination --}}
            </div>
        </div>
    </div>
</div>
@endsection
