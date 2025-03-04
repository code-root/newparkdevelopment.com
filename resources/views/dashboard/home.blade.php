@extends('dashboard.layouts.navbar')
@extends('dashboard.layouts.footer')

@section('title', 'Home')

@section('page-title')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('body')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <h2>Statistics</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Projects</h5>
                            <p class="card-text">{{ $project }}</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable();

        var ctx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($deviceOrders->pluck('device_type')),
                datasets: [{
                    label: 'Orders by Device Type',
                    data: @json($deviceOrders->pluck('total')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
