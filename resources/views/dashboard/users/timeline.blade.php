@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
@section('title')
    {{ 'Home' }}
@endsection
@section('page-title')
    {{-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> --}}
    <li class="breadcrumb-item ">Dashboard</li>
    <li class="breadcrumb-item ">Users</li>
    <li class="breadcrumb-item ">timeline</li>
    <li class="breadcrumb-item active">{{ $username }}</li>
@endsection
@section('body')
    <style>
        * {
            font-weight: bold;
        }
    </style>
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="responsive-table-plugin">
                                <div class="table-rep-plugin">
                                    <div class="" data-pattern="priority-columns">
                                        <table id="datatable-buttons" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Text</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($timeline as $time)
                                                    <tr>
                                                        <td>{{ $time->type }}</td>
                                                        <td>{{ $time->type_id }}</td>
                                                        <td>{{ $time->txt }}</td>
                                                        <td>{{ $time->created_at }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive -->

                                </div> <!-- end .table-rep-plugin-->
                            </div> <!-- end .responsive-table-plugin-->
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
        @endsection
