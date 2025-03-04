@extends('dashboard.layouts.footer')
@extends('dashboard.layouts.navbar')

@section('title')
    {{ 'Home' }}
@endsection

@section('page-title')
    <li class="breadcrumb-item ">Dashboard</li>
    <li class="breadcrumb-item ">Roles</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('body')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Add New Role</span>
            </h4>

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

            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add New Role</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"><strong>Name:</strong></label>
                                {!! Form::text('name', null, ['placeholder' => 'Role Name', 'class' => 'form-control', 'required']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="permissions"><strong>Permissions:</strong></label>
                                <div class="form-check">
                                    @foreach ($permission as $value)
                                        <label class="form-check-label">
                                            {{ Form::checkbox('permission[]', $value->name, false, ['class' => 'form-check-input']) }}
                                            {{ $value->name }}
                                        </label><br />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
